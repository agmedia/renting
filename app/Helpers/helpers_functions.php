<?php

/**
 *
 */

use App\Helpers\CurrencyHelper;
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
            return CurrencyHelper::getMain();
        }

        return CurrencyHelper::list();
    }
}