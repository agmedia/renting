<?php

namespace App\Helpers;


use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Cache;

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


    public static function getMain()
    {
        return Settings::get('language', 'list')->where('status', true)->where('main', true)->first();
    }


    public static function get()
    {

    }


    public static function set()
    {

    }
}
