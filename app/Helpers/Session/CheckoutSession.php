<?php

namespace App\Helpers\Session;

class CheckoutSession
{

    /**
     * @var string
     */
    private static $session_string = 'checkout';


    /**
     * @param $checkout
     * @param $order
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function set($checkout, $order)
    {
        static::setAddress($checkout->setAddress());
        static::setPayment($checkout->setPayment());
        static::setCheckout(serialize($checkout->cleanData()));

        return static::setOrder($order->order_id);
    }


    /**
     * @return bool
     */
    public static function forget()
    {
        static::forgetOrder();
        static::forgetCheckout();
        static::forgetReservationData();

        return static::forgetPayment();
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * SHIPPING ADDRESS DATA
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getAddress()
    {
        return session(static::$session_string . '.address');
    }


    /**
     * @return bool
     */
    public static function hasAddress()
    {
        return session()->has(static::$session_string . '.address');
    }


    /**
     * @param array $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setAddress(array $value)
    {
        return session([static::$session_string . '.address' => $value]);
    }


    /**
     * @return bool
     */
    public static function forgetAddress()
    {
        return session()->forget(static::$session_string . '.address');
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * PAYMENT
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getPayment()
    {
        return session(static::$session_string . '.payment');
    }


    /**
     * @return bool
     */
    public static function hasPayment()
    {
        return session()->has(static::$session_string . '.payment');
    }


    /**
     * @param array|string $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setPayment($value)
    {
        return session([static::$session_string . '.payment' => $value]);
    }


    /**
     * @return bool
     */
    public static function forgetPayment()
    {
        return session()->forget(static::$session_string . '.payment');
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * GEO ZONE
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getGeoZone()
    {
        return session(static::$session_string . '.geo_zone');
    }


    /**
     * @return bool
     */
    public static function hasGeoZone()
    {
        return session()->has(static::$session_string . '.geo_zone');
    }


    /**
     * @param array|string $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setGeoZone($value)
    {
        return session([static::$session_string . '.geo_zone' => $value]);
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * STEPS
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getOrder()
    {
        return session(static::$session_string . '.order');
    }


    /**
     * @return bool
     */
    public static function hasOrder()
    {
        return session()->has(static::$session_string . '.order');
    }


    /**
     * @param array|string $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setOrder($value)
    {
        return session([static::$session_string . '.order' => $value]);
    }


    /**
     * @return bool
     */
    public static function forgetOrder()
    {
        return session()->forget(static::$session_string . '.order');
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * STEPS
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getCheckout()
    {
        return session(static::$session_string . '.checkout');
    }


    /**
     * @return bool
     */
    public static function hasCheckout()
    {
        return session()->has(static::$session_string . '.checkout');
    }


    /**
     * @param array|string $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setCheckout($value)
    {
        return session([static::$session_string . '.checkout' => $value]);
    }


    /**
     * @return bool
     */
    public static function forgetCheckout()
    {
        return session()->forget(static::$session_string . '.checkout');
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * STEPS
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getReservationData()
    {
        return session(static::$session_string . '.reservation_data');
    }


    /**
     * @return bool
     */
    public static function hasReservationData()
    {
        return session()->has(static::$session_string . '.reservation_data');
    }


    /**
     * @param array|string $value
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function setReservationData($value)
    {
        return session([static::$session_string . '.reservation_data' => $value]);
    }


    /**
     * @return bool
     */
    public static function forgetReservationData()
    {
        return session()->forget(static::$session_string . '.reservation_data');
    }
}