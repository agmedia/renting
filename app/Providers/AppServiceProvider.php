<?php

namespace App\Providers;
use App\Models\Back\Settings\Settings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Page;
use App\Models\Front\Catalog\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $maps_key = Settings::get('app', 'google.maps')->first()->key;
        Config::set(['google' => ['maps-key' => $maps_key]]);

        $currency = currency_main();
        $main_currency_symbol = $currency->symbol_right ?: $currency->symbol_left;
        View::share('main_currency_symbol', $main_currency_symbol);

        Paginator::useBootstrap();
    }
}
