<?php

namespace App\Helpers;

use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CurrencyHelper
{

    /**
     * @return mixed
     */
    public static function list()
    {
        return Cache::rememberForever('curr_list', function () {
            return Settings::get('currency', 'list')->where('status', true)->sortBy('sort_order');
        });
    }


    /**
     * @return false|\Illuminate\Support\Collection
     */
    public static function adminList()
    {
        return Settings::get('currency', 'list')->sortBy('sort_order');
    }


    /**
     * @return mixed
     */
    public static function getMain()
    {
        return self::mainSession();
    }


    /**
     * @param $code
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function mainSession($code = null)
    {
        if ( ! $code && session()->has('main_curr')) {
            return session('main_curr');
        }

        if ($code) {
            $main = self::list()->where('code', $code)->first();
        } else {
            $main = self::list()->where('main', true)->first();
        }

        session(['main_curr' => $main]);

        return $main;
    }

}
