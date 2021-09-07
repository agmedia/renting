<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Session\CheckoutSession;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
     * @var mixed|null
     */
    protected $method = null;

    /**
     * @var mixed|null
     */
    protected $response_methods = null;


    /**
     * PaymentMethod constructor.
     *
     * @param string|null $code
     */
    public function __construct(string $code = null)
    {
        $this->methods = $this->list();
        $this->response_methods = collect();

        if ($code) {
            $this->method = $this->methods->where('code', $code);
        }
    }


    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * @return array|false|Collection
     */
    public function getMethods()
    {
        return $this->methods;
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


    /**
     * @param int $zone
     *
     * @return $this
     */
    public function findGeo(int $zone)
    {
        foreach ($this->methods as $method) {
            if ($method->geo_zone == $zone || ! $method->geo_zone) {
                $this->response_methods->push($method);
            }
        }

        return $this;
    }


    /**
     * @param string $shipping
     *
     * @return $this
     */
    public function checkShipping(string $shipping)
    {
        if ($shipping == 'pickup') {
            $this->response_methods = collect();

            foreach ($this->methods as $method) {
                if ($method->code == 'bank') {
                    $this->response_methods->push($method);
                }
            }
        }

        return $this;
    }


    /**
     * @return Collection
     */
    public function resolve(): Collection
    {
        return $this->response_methods;
    }


    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param $order
     *
     * @return mixed|null
     */
    public function resolveForm($order)
    {
        if ($this->method->count()) {
            $provider = $this->providers($this->method->first()->code);
            $payment = new $provider($order);

            return $payment->resolveFormView($this->method->collect());
        }

        return null;
    }


    /**
     * @param $order
     *
     * @return mixed|null
     */
    public function finish(\App\Models\Back\Orders\Order $order, Request $request)
    {
        if ($this->method->count()) {
            $provider = $this->providers($this->method->first()->code);
            $payment = new $provider($order);

            return $payment->finishOrder($order, $request);
        }

        return null;
    }


    /**
     * @param string|null $key
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function providers(string $key = null)
    {
        $providers = config('settings.payment.providers');

        if ($key) {
            return $providers[$key];
        }

        return $providers;
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