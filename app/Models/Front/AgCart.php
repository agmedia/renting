<?php

namespace App\Models\Front;

use App\Helpers\Session\CheckoutSession;
use App\Models\Front\Cart\Totals;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\ProductAction;
use App\Models\Front\Checkout\PaymentMethod;
use App\Models\Front\Checkout\ShippingMethod;
use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgCart extends Model
{

    /**
     * @var string
     */
    private $cart_id;

    /**
     * @var
     */
    private $cart;


    /**
     * AgCart constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->cart_id = $id;
        $this->cart    = Cart::session($id);
    }


    /**
     * @return array
     */
    public function get()
    {
        $detail_conditions = $this->setCartConditions();

        $response = [
            'id'         => $this->cart_id,
            'coupon'     => session()->has('sl_cart_coupon') ? session('sl_cart_coupon') : '',
            'items'      => $this->cart->getContent(),
            'count'      => $this->cart->getTotalQuantity(),
            'subtotal'   => $this->cart->getSubTotal(),
            'conditions' => $this->cart->getConditions(),
            'detail_con' => $detail_conditions,
            'total'      => $this->cart->getTotal(),
        ];
        //$response['tax'] = $this->getTax($response);
        //$response['total'] = $this->cart->getTotal() + $response['tax'][0]['value'];

        //$response['totals'] = $this->getTotals();

        //Log::info($response);

        return $response;
    }


    /**
     * @param      $request
     * @param null $id
     *
     * @return array
     */
    public function add($request, $id = null)
    {
        Log::info('add($request, $id = null)');

        if ($id) {
            // Updejtaj artikl sa apsolutnom količinom.
            foreach ($this->cart->getContent() as $item) {
                if ($item->id == $request['item']['id']) {
                    return $this->updateCartItem($item->id, $request);
                }
            }
        }

        return $this->addToCart($request);
    }


    /**
     * @param $id
     *
     * @return array
     */
    public function remove($id)
    {
        $this->cart->remove($id);

        return $this->get();
    }


    /**
     * @param $coupon
     *
     * @return array
     */
    public function coupon($coupon)
    {
        $items = $this->cart->getContent();

        // Refreshaj košaricu sa upisanim kuponom.
        foreach ($items as $item) {
            $this->remove($item->id);
            $this->addToCart($this->resolveItemRequest($item));
        }

        /*$has_coupon = ProductAction::active()->where('coupon', $coupon)->get();

        if ($has_coupon->count()) {
            return 1;
        }*/

        return 0;
    }


    /**
     *
     * @return array
     */
    public function flush()
    {
        return $this->cart->clear();
    }
    
    
    /**
     * @param $item
     *
     * @return array[]
     */
    public function resolveItemRequest($item)
    {
        return [
            'item' => [
                'id'       => $item->id,
                'quantity' => $item->quantity
            ]
        ];
    }


    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    public function setCartConditions()
    {
        $this->cart->clearCartConditions();

        $shipping_method = ShippingMethod::condition($this->cart);
        $payment_method = PaymentMethod::condition($this->cart);

        if ($payment_method) {
            $str = str_replace('+', '', $payment_method->getValue());
            if (number_format($str) > 0) {
                $this->cart->condition($payment_method);
            }
        }

        if ($shipping_method) {
            $this->cart->condition($shipping_method);
        }

        // Style response array
        $response = [];

        foreach ($this->cart->getConditions() as $condition) {
            $value = $condition->getValue();

            $response[] = [
                'name' => $condition->getName(),
                'type' => $condition->getType(),
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => $value,
                'attributes' => $condition->getAttributes()
            ];
        }

        return $response;
    }


    /**
     * @param $request
     *
     * @return array
     */
    private function addToCart($request): array
    {
        Log::info('addToCart($request): array');

        $this->cart->add($this->structureCartItem($request));

        return $this->get();
    }


    /**
     * @param $id
     * @param $request
     *
     * @return array
     */
    private function updateCartItem($id, $request): array
    {
        $this->cart->update($id, [
            'quantity' => [
                'relative' => false,
                'value'    => $request['item']['quantity']
            ],
        ]);

        return $this->get();
    }


    /**
     * @param $request
     *
     * @return array
     */
    private function structureCartItem($request)
    {
        $product = Product::where('id', $request['item']['id'])->first();

        $response = [
            'id'              => $product->id,
            'name'            => $product->name,
            'price'           => $product->price,
            'quantity'        => $request['item']['quantity'],
            'associatedModel' => $product,
            'attributes'      => $this->structureCartItemAttributes($product)
        ];

        $conditions = $this->structureCartItemConditions($product);

        if ($conditions) {
            $response['conditions'] = $conditions;
        }

        return $response;
    }


    /**
     * @param $product
     *
     * @return string[]
     */
    private function structureCartItemAttributes($product)
    {
        return [
            'path' => $product->url,
            'tax' => $product->tax($product->tax_id)
        ];
    }


    /**
     * @param $product
     *
     * @return CartCondition|bool
     * @throws \Darryldecode\Cart\Exceptions\InvalidConditionException
     */
    private function structureCartItemConditions($product)
    {
        // Ako artikl ima akciju.
        if ($product->special()) {
            return new CartCondition([
                'name'  => 'Akcija',
                'type'  => 'promo',
                'value' => -($product->price - $product->special())
            ]);
        }

        // Ako nema akcije na artiklu.
        // Ako nije ispravan kupon.
        return false;
    }


    /**
     * @param $cart
     *
     * @return array[]
     */
    private function getTax($cart)
    {
        $without = $cart['subtotal'] / 1.25;

        /*return [
            0 => [
                'title' => 'Iznos bez PDV-a',
                'value' => $without
            ],
            1 => [
                'title' => 'PDV (25%)',
                'value' => $without * 0.25
            ]
        ];*/
        return [
            0 => [
                'title' => 'PDV (25%)',
                'value' => /*$cart['subtotal'] * 0.25*/0
            ]
        ];
    }


    private function getTotals()
    {
        $response = ['tax' => []];

        /*$totals = new Totals($this->cart);

        if ($totals->hasActive()) {
            $response = $totals->fetch();
        }*/

        return $response;
    }

}
