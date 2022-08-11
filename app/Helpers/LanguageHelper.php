<?php

namespace App\Helpers;


use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageHelper
{

    /**
     * @return mixed
     */
    public static function list()
    {
        return Cache::rememberForever('lang_list', function () {
            return Settings::get('language', 'list')->where('status', true)->sortBy('sort_order');
        });
    }


    /**
     * @return false|\Illuminate\Support\Collection
     */
    public static function adminList()
    {
        return Settings::get('language', 'list')->sortBy('sort_order');
    }


    /**
     * @return mixed
     */
    public static function getMain()
    {
        return Cache::rememberForever('lang_' . LaravelLocalization::getCurrentLocale(), function () {
            return Settings::get('language', 'list')
                           ->where('status', true)
                           ->where('code', LaravelLocalization::getCurrentLocale())
                           ->first();
        });
    }


    /**
     * @return string
     */
    public static function getCurrentLocale()
    {
        return LaravelLocalization::getCurrentLocale();
    }


    public static function set()
    {

    }
}
