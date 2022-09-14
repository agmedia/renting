<?php

/**
 *
 */
if ( ! function_exists('ag_lang')) {
    /**
     * @param false $main
     *
     * @return mixed
     */
    function ag_lang($main = false)
    {
        if ($main) {
            return \App\Helpers\LanguageHelper::getMain();
        }

        return \App\Helpers\LanguageHelper::list();
    }
}

/**
 *
 */
if ( ! function_exists('current_locale')) {
    /**
     * @return string
     */
    function current_locale()
    {
        return \App\Helpers\LanguageHelper::getCurrentLocale();
    }
}

/**
 *
 */
if ( ! function_exists('ag_currencies')) {
    /**
     * @param false $main
     *
     * @return mixed
     */
    function ag_currencies($main = false)
    {
        if ($main) {
            return \App\Helpers\CurrencyHelper::getMain();
        }

        return \App\Helpers\CurrencyHelper::list();
    }
}