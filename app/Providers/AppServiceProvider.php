<?php

namespace App\Providers;

use App\Models\Front\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        //

        $uvjeti_kupnje = Page::where('subgroup', 'Uvjeti kupnje')->get();
        View::share('uvjeti_kupnje', $uvjeti_kupnje);

        $nacini_placanja = Page::where('subgroup', 'Načini plaćanja')->get();
        View::share('nacini_placanja', $nacini_placanja);

        Paginator::useBootstrap();
    }
}
