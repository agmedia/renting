<?php

namespace App\Helpers;

use App\Models\Back\Settings\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Currency
{

    /**
     * @return Collection
     */
    public static function list(): Collection
    {
        return Cache::rememberForever('currency_list', function () {
            return Settings::get('currency', 'list')->where('status', '=', true)->sortBy('sort_order');
        });
    }


    /**
     * @param      $price
     * @param bool $text_price
     *
     * @return Collection|string|bool
     */
    public static function main($price = null, bool $text_price = false)
    {
        return static::resolveCurrency(self::session(), $price, $text_price);
    }


    /**
     * @param      $price
     * @param bool $text_price
     *
     * @return Collection|string|bool
     */
    public static function secondary($price = null, bool $text_price = false)
    {
        $list = self::list();

        $currency = Cache::rememberForever('currency_secondary', function () use ($list) {
            return $list->where('main', '=', false)->first();
        });

        return static::resolveCurrency($currency, $price, $text_price);
    }


    /**
     * @return bool
     */
    public static function showSecondary(): bool
    {
        return Cache::rememberForever('currency_secondary_show', function () {
            return Settings::get('currency', 'show.second') ? true : false;
        });
    }


    /**
     * @param string|null $code
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function session(string $code = null)
    {
        if ( ! $code && session()->has('main_currency')) {
            return session('main_currency');
        }

        $list = self::list();

        if ($code) {
            $main = $list->where('code', '=', $code)->first();
        } else {
            $main = $list->where('main', '=', true)->first();
        }

        session(['main_currency' => $main]);

        return $main;
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @param      $currency
     * @param      $price
     * @param bool $text_price
     *
     * @return false|mixed|string
     */
    private static function resolveCurrency($currency, $price, bool $text_price = false)
    {
        if ($currency) {
            if ($price) {
                return static::resolvePrice($currency, $price, $text_price);
            }

            return $currency;
        }

        return false;
    }


    /**
     * @param stdClass   $currency
     * @param            $price
     * @param bool       $text_price
     *
     * @return string
     */
    private static function resolvePrice(\stdClass $currency, $price, bool $text_price = false): string
    {
        if ($text_price) {
            $left  = $currency->symbol_left ? $currency->symbol_left . ' ' : '';
            $right = $currency->symbol_right ? ' ' . $currency->symbol_right : '';

            return $left . number_format(($price * $currency->value), $currency->decimal_places, ',', '.') . $right;
        }

        return number_format(($price * $currency->value), $currency->decimal_places);
    }
}