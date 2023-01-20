<?php

/**
 *
 */

use App\Helpers\Currency;
use App\Helpers\LanguageHelper;

if ( ! function_exists('ag_lang')) {
    /**
     * @param bool $main
     *
     * @return mixed
     */
    function ag_lang(bool $main = false)
    {
        if ($main) {
            return LanguageHelper::getMain();
        }

        return LanguageHelper::list();
    }
}

/**
 *
 */
if ( ! function_exists('current_locale')) {
    /**
     * @param bool $native
     *
     * @return string
     */
    function current_locale(bool $native = false): string
    {
        $current = LanguageHelper::getCurrentLocale();

        if ($native) {
            return config('laravellocalization.supportedLocales.' . $current . '.regional');
        }

        return $current;
    }
}

/**
 *
 */
if ( ! function_exists('ag_currencies')) {
    /**
     * @param bool $main
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    function ag_currencies(bool $main = false)
    {
        if ($main) {
            return Currency::session();
        }

        return Currency::list();
    }
}

/**
 *
 */
if ( ! function_exists('currency_main')) {
    /**
     * @param      $price
     * @param bool $text_price
     *
     * @return bool|\Illuminate\Support\Collection|string
     */
    function currency_main($price = null, bool $text_price = false)
    {
        return Currency::main($price, $text_price);
    }
}

/**
 *
 */
if ( ! function_exists('currency_secondary')) {
    /**
     * @param      $price
     * @param bool $text_price
     *
     * @return bool|\Illuminate\Support\Collection|string
     */
    function currency_secondary($price = null, bool $text_price = false)
    {
        return Currency::secondary($price, $text_price);
    }
}

/**
 *
 */
if ( ! function_exists('show_secondary_currency')) {
    /**
     * @return bool
     */
    function show_secondary_currency()
    {
        return Currency::showSecondary();
    }
}

/**
 *
 */
if ( ! function_exists('crypt_apartment')) {
    /**
     * @param int $number
     *
     * @return int
     */
    function crypt_apartment(int $number): int
    {
        return $number * 9;
    }
}

/**
 *
 */
if ( ! function_exists('decrypt_apartment')) {
    /**
     * @param int $number
     *
     * @return int
     */
    function decrypt_apartment(int $number): int
    {
        return $number / 9;
    }
}