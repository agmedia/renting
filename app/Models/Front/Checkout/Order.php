<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Helper;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderProduct;
use App\Models\Back\Orders\OrderTotal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var array
     */
    public $order = [];


    /**
     * Order constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->order = $data;
    }


    /**
     * @param array $data
     *
     * @return bool
     */
    public function make(array $data = [])
    {
        if ( ! empty($data)) {
            $this->order = $data;
        }

        if ( ! empty($this->order) && isset($this->order['cart'])) {
            $user_id = auth()->user() ? auth()->user()->id : 0;

            $order_id = \App\Models\Back\Order::insertGetId([
                'user_id'          => $user_id,
                'affiliate_id'     => 0,
                'order_status_id'  => 1,
                'total'            => $this->order['cart']['total'],
                'payment_fname'    => $this->order['address']['fname'],
                'payment_lname'    => $this->order['address']['lname'],
                'payment_address'  => $this->order['address']['address'],
                'payment_zip'      => $this->order['address']['zip'],
                'payment_city'     => $this->order['address']['city'],
                'payment_state'    => $this->order['address']['state'],
                'payment_phone'    => $this->order['address']['phone'] ?: null,
                'payment_email'    => $this->order['address']['email'],
                'payment_method'   => $this->order['payment']->title,
                'payment_code'     => $this->order['payment']->code,
                'shipping_fname'   => $this->order['address']['fname'],
                'shipping_lname'   => $this->order['address']['lname'],
                'shipping_address' => $this->order['address']['address'],
                'shipping_zip'     => $this->order['address']['zip'],
                'shipping_city'    => $this->order['address']['city'],
                'shipping_state'   => $this->order['address']['state'],
                'shipping_phone'   => $this->order['address']['phone'] ?: null,
                'shipping_email'   => $this->order['address']['email'],
                'shipping_method'  => $this->order['shipping']->title,
                'shipping_code'    => $this->order['shipping']->code,
                'company'          => '',
                'oib'              => '',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);

            // HISTORY
            OrderHistory::insert([
                'order_id'   => $order_id,
                'user_id'    => $user_id,
                'comment'    => 'Narudžba napravljena.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            if ($order_id) {
                // PRODUCTS
                foreach ($this->order['cart']['items'] as $item) {
                    $discount = 0;
                    $price    = $item->price;

                    if ($item->associatedModel->special) {
                        $price    = $item->associatedModel->special;
                        $discount = Helper::calculateDiscount($item->price, $price);
                    }

                    OrderProduct::insert([
                        'order_id'   => $order_id,
                        'product_id' => $item->id,
                        'name'       => $item->name,
                        'quantity'   => $item->quantity,
                        'org_price'  => $item->price,
                        'discount'   => $discount ? number_format($discount, 2) : 0,
                        'price'      => $price,
                        'total'      => $item->quantity * $price,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                // SUBTOTAL
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'subtotal',
                    'title'      => 'Ukupno',
                    'value'      => $this->order['cart']['subtotal'],
                    'sort_order' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // CONDITIONS on Total
                foreach ($this->order['cart']['conditions'] as $name => $condition) {
                    if ($condition->getType() == 'shipping') {
                        OrderTotal::insert([
                            'order_id'   => $order_id,
                            'code'       => 'shipping',
                            'title'      => $name,
                            'value'      => $condition->parsedRawValue,
                            'sort_order' => $condition->getOrder(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }

                // TOTAL
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'total',
                    'title'      => 'Sveukupno',
                    'value'      => $this->order['cart']['total'],
                    'sort_order' => 5,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                return true;
            }
        }

        return false;
    }
}
