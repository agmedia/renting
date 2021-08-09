<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Session\CheckoutSession;
use App\Models\Back\Settings\Settings;
use Illuminate\Support\Collection;

/**
 * Class ShippingMethod
 * @package App\Models\Front\Checkout
 */
class PaymentMethod
{

    /**
     * @var array|false|Collection
     */
    protected $methods;


    /**
     * ShippingMethod constructor.
     */
    public function __construct()
    {
        $this->methods = $this->list();
    }


    /**
     * @param bool $only_active
     *
     * @return array|false|Collection
     */
    public function list(bool $only_active = true)
    {
        return Settings::getList('payment', 'list.%', $only_active);
    }


    /**
     * @param int $id
     *
     * @return mixed
     */
    public function id(int $id)
    {
        return $this->methods->where('id', $id)->first();
    }


    /**
     * @param string $code
     *
     * @return mixed
     */
    public function find(string $code)
    {
        //Log::info($this->methods->where('code', $code)->first()->code);
        return $this->methods->where('code', $code)->first();
    }


    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/


    /**
     * @return \Darryldecode\Cart\CartCondition|false
     * @throws \Darryldecode\Cart\Exceptions\InvalidConditionException
     */
    public static function condition()
    {
        $payment = false;
        $condition = false;

        if (CheckoutSession::hasPayment()) {
            $payment = (new PaymentMethod())->find(CheckoutSession::getPayment());
        }

        if ($payment) {
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => $payment->title,
                'type' => 'shipping',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => '+' . $payment->data->price ?: 0,
                'attributes' => [
                    'description' => $payment->data->short_description ?: '',
                    'geo_zone' => $payment->geo_zone ?: 0
                ]
            ));
        }

        return $condition;
    }
}