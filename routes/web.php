<?php

use App\Actions\Fortify\ForgotPasswordController;
use App\Http\Controllers\Api\v2\CartController;
use App\Http\Controllers\Api\v2\FilterController;
use App\Http\Controllers\Back\ApartmentController;
use App\Http\Controllers\Back\CalendarController;
use App\Http\Controllers\Back\Catalog\AuthorController;
use App\Http\Controllers\Back\Marketing\ReviewController;
use App\Http\Controllers\Back\Settings\OptionController;
use App\Http\Controllers\Back\Settings\System\AmenitiesController;
use App\Http\Controllers\Back\Settings\System\ApplicationController;
use App\Http\Controllers\Back\Settings\System\CategoryController;
use App\Http\Controllers\Back\Catalog\ProductController;
use App\Http\Controllers\Back\Catalog\PublisherController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\Marketing\GalleryController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\Marketing\ActionController;
use App\Http\Controllers\Back\Marketing\BlogController;
use App\Http\Controllers\Back\Settings\App\CurrencyController;
use App\Http\Controllers\Back\Settings\App\GeoZoneController;
use App\Http\Controllers\Back\Settings\App\LanguagesController;
use App\Http\Controllers\Back\Settings\App\OrderStatusController;
use App\Http\Controllers\Back\Settings\App\PaymentController;
use App\Http\Controllers\Back\Settings\App\ShippingController;
use App\Http\Controllers\Back\Settings\App\TaxController;
use App\Http\Controllers\Back\Settings\System\FaqController;
use App\Http\Controllers\Back\Settings\HistoryController;
use App\Http\Controllers\Back\Settings\System\PageController;
use App\Http\Controllers\Back\Settings\QuickMenuController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\Widget\WidgetController;
use App\Http\Controllers\Back\Widget\WidgetGroupController;
use App\Http\Controllers\Front\CatalogRouteController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\SetupController;
use Illuminate\Support\Facades\Route;


/*Route::domain('https://images.antikvarijatbibl.lin73.host25.com/')->group(function () {
    Route::get('media/img/apartments/{id}/{image}', function ($id, $image) {
        \Illuminate\Support\Facades\Log::info($id . ' --- ' . $image);
    });
});*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * BACK ROUTES LOCALIZED
 */
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::middleware(['auth:sanctum', 'verified', 'no.customers'])->prefix('admin')->group(function () {

        // DASHBOARD
        Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('setRoles', [DashboardController::class, 'setRoles'])->name('roles.set');
        Route::get('mailing-test', [DashboardController::class, 'mailing'])->name('mailing.test');

        // APARTMANI
        Route::get('apartments', [ApartmentController::class, 'index'])->name('apartments');
        Route::get('apartment/create', [ApartmentController::class, 'create'])->name('apartments.create');
        Route::post('apartment', [ApartmentController::class, 'store'])->name('apartments.store');
        Route::get('apartment/{apartman}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit');
        Route::patch('apartment/{apartman}', [ApartmentController::class, 'update'])->name('apartments.update');
        Route::delete('apartment/{apartman}', [ApartmentController::class, 'destroy'])->name('apartments.destroy');

        // KALENDAR
        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
        Route::get('calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
        Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
        Route::get('calendar/{calendar}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
        Route::patch('calendar/{calendar}', [CalendarController::class, 'update'])->name('calendar.update');
        Route::delete('calendar/{calendar}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

        // NARUDŽBE
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('order/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('order', [OrderController::class, 'store'])->name('orders.store');
        Route::get('order/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('order/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('order/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::get('order/{order}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');

        // MARKETING
        Route::prefix('marketing')->group(function () {
            // BLOG
            Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
            Route::get('blog/create', [BlogController::class, 'create'])->name('blogs.create');
            Route::post('blog', [BlogController::class, 'store'])->name('blogs.store');
            Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
            Route::patch('blog/{blog}', [BlogController::class, 'update'])->name('blogs.update');
            Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

            // AKCIJE
            Route::get('galleries', [GalleryController::class, 'index'])->name('galleries');
            Route::get('gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
            Route::post('gallery', [GalleryController::class, 'store'])->name('gallery.store');
            Route::get('gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
            Route::patch('gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
            Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

            // AKCIJE
            Route::get('actions', [ActionController::class, 'index'])->name('actions');
            Route::get('action/create', [ActionController::class, 'create'])->name('actions.create');
            Route::post('action', [ActionController::class, 'store'])->name('actions.store');
            Route::get('action/{action}/edit', [ActionController::class, 'edit'])->name('actions.edit');
            Route::patch('action/{action}', [ActionController::class, 'update'])->name('actions.update');
            Route::delete('action/{action}', [ActionController::class, 'destroy'])->name('actions.destroy');

            // REWIEVS
            Route::get('reviews', [ReviewController::class, 'index'])->name('reviews');
            Route::get('review/create', [ReviewController::class, 'create'])->name('reviews.create');
            Route::post('review', [ReviewController::class, 'store'])->name('reviews.store');
            Route::get('review/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
            Route::patch('review/{review}', [ReviewController::class, 'update'])->name('reviews.update');
            Route::delete('review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

            // WIDGETS
            Route::prefix('widgets')->group(function () {
                Route::get('/', [WidgetController::class, 'index'])->name('widgets');
                Route::get('create', [WidgetController::class, 'create'])->name('widget.create');
                Route::post('/', [WidgetController::class, 'store'])->name('widget.store');
                Route::get('{widget}/edit', [WidgetController::class, 'edit'])->name('widget.edit');
                Route::patch('{widget}', [WidgetController::class, 'update'])->name('widget.update');
                // GROUP
                Route::prefix('groups')->group(function () {
                    Route::get('create', [WidgetGroupController::class, 'create'])->name('widget.group.create');
                    Route::post('/', [WidgetGroupController::class, 'store'])->name('widget.group.store');
                    Route::get('{widget}/edit', [WidgetGroupController::class, 'edit'])->name('widget.group.edit');
                    Route::patch('{widget}', [WidgetGroupController::class, 'update'])->name('widget.group.update');
                });
            });
        });

        // KORISNICI
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('user/create', [UserController::class, 'create'])->name('users.create');
        Route::post('user', [UserController::class, 'store'])->name('users.store');
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('user/{user}', [UserController::class, 'update'])->name('users.update');

        // POSTAVKE
        Route::prefix('settings')->group(function () {
            // AMENITIES
            Route::get('amenities', [AmenitiesController::class, 'index'])->name('amenities');

            // OPTIONS: APARTMENT ADDITIONAL PAYMENTS
            Route::get('options', [OptionController::class, 'index'])->name('options');
            Route::get('option/create', [OptionController::class, 'create'])->name('options.create');
            Route::post('option', [OptionController::class, 'store'])->name('options.store');
            Route::get('option/{option}/edit', [OptionController::class, 'edit'])->name('options.edit');
            Route::patch('option/{option}', [OptionController::class, 'update'])->name('options.update');
            Route::delete('option/{option}', [OptionController::class, 'destroy'])->name('options.destroy');

            // SISTEM
            Route::prefix('system')->group(function () {
                // KATEGORIJE
                Route::get('categories', [CategoryController::class, 'index'])->name('categories');
                Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
                Route::post('category', [CategoryController::class, 'store'])->name('category.store');
                Route::get('category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
                Route::patch('category/{category}', [CategoryController::class, 'update'])->name('category.update');
                Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

                // APPLICATION SETTINGS
                Route::get('application', [ApplicationController::class, 'index'])->name('application.settings');

                // INFO PAGES
                Route::get('pages', [PageController::class, 'index'])->name('pages');
                Route::get('stranica/create', [PageController::class, 'create'])->name('pages.create');
                Route::post('stranica', [PageController::class, 'store'])->name('pages.store');
                Route::get('stranica/{stranica}/edit', [PageController::class, 'edit'])->name('pages.edit');
                Route::patch('stranica/{stranica}', [PageController::class, 'update'])->name('pages.update');
                Route::delete('stranica/{stranica}', [PageController::class, 'destroy'])->name('pages.destroy');

                // FAQ
                Route::get('faqs', [FaqController::class, 'index'])->name('faqs');
                Route::get('faq/create', [FaqController::class, 'create'])->name('faqs.create');
                Route::post('faq', [FaqController::class, 'store'])->name('faqs.store');
                Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
                Route::patch('faq/{faq}', [FaqController::class, 'update'])->name('faqs.update');
                Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

                // CHUNKS
                Route::get('chunks', [FaqController::class, 'index'])->name('chunks');
                Route::get('chunk/create', [FaqController::class, 'create'])->name('chunks.create');
                Route::post('chunk', [FaqController::class, 'store'])->name('chunks.store');
                Route::get('chunk/{chunk}/edit', [FaqController::class, 'edit'])->name('chunks.edit');
                Route::patch('chunk/{chunk}', [FaqController::class, 'update'])->name('chunks.update');
                Route::delete('chunk/{chunk}', [FaqController::class, 'destroy'])->name('chunks.destroy');

            });

            // LOCALE SETTINGS
            Route::prefix('application')->group(function () {
                //
                Route::get('languages', [LanguagesController::class, 'index'])->name('languages');
                // GEO ZONES
                Route::get('geo-zones', [GeoZoneController::class, 'index'])->name('geozones');
                Route::get('geo-zone/create', [GeoZoneController::class, 'create'])->name('geozones.create');
                Route::post('geo-zone', [GeoZoneController::class, 'store'])->name('geozones.store');
                Route::get('geo-zone/{geozone}/edit', [GeoZoneController::class, 'edit'])->name('geozones.edit');
                Route::patch('geo-zone/{geozone}', [GeoZoneController::class, 'store'])->name('geozones.update');
                Route::delete('geo-zone/{geozone}', [GeoZoneController::class, 'destroy'])->name('geozones.destroy');
                //
                Route::get('order-statuses', [OrderStatusController::class, 'index'])->name('order.statuses');
                //
                Route::get('payments', [PaymentController::class, 'index'])->name('payments');
                Route::get('taxes', [TaxController::class, 'index'])->name('taxes');
                Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies');
            });

            // HISTORY
            Route::get('history', [HistoryController::class, 'index'])->name('history');
            Route::get('history/log/{history}', [HistoryController::class, 'show'])->name('history.show');
        });

        // SETTINGS
        Route::get('/clean/cache', [QuickMenuController::class, 'cache'])->name('cache');
        Route::get('maintenance/on', [QuickMenuController::class, 'maintenanceModeON'])->name('maintenance.on');
        Route::get('maintenance/off', [QuickMenuController::class, 'maintenanceModeOFF'])->name('maintenance.off');
    });
});

/**
 * API Routes
 */
Route::prefix('api/v2')->group(function () {
    // SEARCH
    Route::get('pretrazi', [CatalogRouteController::class, 'search'])->name('api.front.search');

    Route::post('/apartments/sync-url', [ApartmentController::class, 'syncURL'])->name('api.apartments.sync.url');
    Route::get('/apartments/autocomplete', [\App\Http\Controllers\Api\v2\ProductController::class, 'autocomplete'])->name('apartments.autocomplete');
    Route::post('/apartments/image/delete', [ApartmentController::class, 'destroyImage'])->name('apartments.destroy.image');
    //Route::post('/apartments/change/status', [\App\Http\Controllers\Api\v2\ProductController::class, 'changeStatus'])->name('apartments.change.status');
    //Route::post('apartments/update-item/single', [\App\Http\Controllers\Api\v2\ProductController::class, 'updateItem'])->name('apartments.update.item');

    Route::post('/actions/destroy/api', [ActionController::class, 'destroyApi'])->name('actions.destroy.api');
    Route::post('/options/destroy/api', [OptionController::class, 'destroyApi'])->name('options.destroy.api');
    Route::post('/reviews/destroy/api', [ReviewController::class, 'destroyApi'])->name('reviews.destroy.api');
    Route::post('/apartments/destroy/api', [ApartmentController::class, 'destroyApi'])->name('apartments.destroy.api');
    Route::post('/gallery/destroy/api', [GalleryController::class, 'destroyApi'])->name('gallery.destroy.api');
    Route::post('/gallery/destroy/image', [GalleryController::class, 'destroyImage'])->name('gallery.destroy.image');
    Route::post('/blogs/destroy/api', [BlogController::class, 'destroyApi'])->name('blogs.destroy.api');

    // CALENDAR
    Route::post('/calendar/move', [CalendarController::class, 'move'])->name('api.calendar.move');

    // FILTER
    Route::prefix('filter')->group(function () {
        Route::post('/getCategories', [FilterController::class, 'categories']);
        Route::post('/getProducts', [FilterController::class, 'apartments']);
    });

    // SETTINGS
    Route::prefix('settings')->group(function () {
        // WIDGET
        Route::prefix('widget')->group(function () {
            Route::post('destroy', [WidgetController::class, 'destroy'])->name('widget.destroy');
            Route::get('get-links', [WidgetController::class, 'getLinks'])->name('widget.api.get-links');
        });

        // SYSTEM SETTINGS
        Route::prefix('system')->group(function () {
            // AMENITIES
            Route::prefix('amenities')->group(function () {
                Route::post('store', [AmenitiesController::class, 'store'])->name('api.amenities.store');
                Route::post('destroy', [AmenitiesController::class, 'destroy'])->name('api.amenities.destroy');
            });
            // APPLICATION
            Route::prefix('application')->group(function () {
                Route::post('basic/store', [ApplicationController::class, 'basicInfoStore'])->name('api.application.basic.store');
                Route::post('maps-api/store', [ApplicationController::class, 'storeGoogleMapsApiKey'])->name('api.application.google-api.store.key');
            });
        });

        // APPLICATION SETTINGS
        Route::prefix('app')->group(function () {
            // GEO ZONE
            /*Route::prefix('geo-zone')->group(function () {
                Route::post('get-state-zones', 'Back\Settings\Store\GeoZoneController@getStateZones')->name('geo-zone.get-state-zones');
                Route::post('store', 'Back\Settings\Store\GeoZoneController@store')->name('geo-zone.store');
                Route::post('destroy', 'Back\Settings\Store\GeoZoneController@destroy')->name('geo-zone.destroy');
            });*/
            // LANGUAGES
            Route::prefix('languages')->group(function () {
                Route::post('store', [LanguagesController::class, 'store'])->name('api.languages.store');
                Route::post('store/main', [LanguagesController::class, 'storeMain'])->name('api.languages.store.main');
                Route::post('destroy', [LanguagesController::class, 'destroy'])->name('api.languages.destroy');
            });

            // ORDER STATUS
            Route::prefix('order-status')->group(function () {
                Route::post('store', [OrderStatusController::class, 'store'])->name('api.order.status.store');
                Route::post('destroy', [OrderStatusController::class, 'destroy'])->name('api.order.status.destroy');
                Route::post('change', [OrderController::class, 'api_status_change'])->name('api.order.status.change');
            });
            // PAYMENTS
            Route::prefix('payment')->group(function () {
                Route::post('store', [PaymentController::class, 'store'])->name('api.payment.store');
                Route::post('destroy', [PaymentController::class, 'destroy'])->name('api.payment.destroy');
            });
            // SHIPMENTS
            Route::prefix('shipping')->group(function () {
                Route::post('store', [ShippingController::class, 'store'])->name('api.shipping.store');
                Route::post('destroy', [ShippingController::class, 'destroy'])->name('api.shipping.destroy');
            });
            // TAXES
            Route::prefix('taxes')->group(function () {
                Route::post('store', [TaxController::class, 'store'])->name('api.taxes.store');
                Route::post('destroy', [TaxController::class, 'destroy'])->name('api.taxes.destroy');
            });
            // CURRENCIES
            Route::prefix('currencies')->group(function () {
                Route::post('store', [CurrencyController::class, 'store'])->name('api.currencies.store');
                Route::post('store/main', [CurrencyController::class, 'storeMain'])->name('api.currencies.store.main');
                Route::post('destroy', [CurrencyController::class, 'destroy'])->name('api.currencies.destroy');
            });
            // TOTALS
            /*Route::prefix('totals')->group(function () {
                Route::post('store', 'Back\Settings\Store\TotalController@store')->name('totals.store');
                Route::post('destroy', 'Back\Settings\Store\TotalController@destroy')->name('totals.destroy');
            });*/
        });
    });
});

/**
 * FRONT ROUTES LOCALIZED
 */
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    /**
     * REGISTERED CUSTOMER BACK ROUTES
     */
    Route::middleware(['auth:sanctum', 'verified'])->prefix('moj-racun')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('moj-racun');
        Route::patch('/snimi/{user}', [CustomerController::class, 'save'])->name('moj-racun.snimi');
        Route::get('/narudzbe', [CustomerController::class, 'orders'])->name('moje-narudzbe');
    });

    /**
     * FRONT ROUTES
     */
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('info/{page}', [HomeController::class, 'page'])->name('page');
    Route::get('faq', [HomeController::class, 'faq'])->name('faq');
    //
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'checkoutView'])->name('checkout.view');
    Route::get('/naplata', [CheckoutController::class, 'success'])->name('naplata');
    // SETUP ROUTES
    Route::get('cache/image', [SetupController::class, 'imageCache']);
    Route::get('cache/thumb', [SetupController::class, 'thumbCache']);
    Route::get('set/currency', [SetupController::class, 'setMainCurrency'])->name('set.currency');
    //
    Route::get('/kontakt', [HomeController::class, 'contact'])->name('kontakt');
    Route::post('/kontakt/posalji', [HomeController::class, 'sendContactMessage'])->name('poruka');
    //
    Route::get('/{apartment}', [HomeController::class, 'apartment'])->name('apartment');
    Route::get('apartment/ics/{apartment}', [HomeController::class, 'apartmentICS'])->name('apartment.ics');

    //Route::get('blog/{blog?}', [CatalogRouteController::class, 'blog'])->name('catalog.route.blog');
    /**
     * Sitemap routes
     */
    Route::redirect('/sitemap.xml', '/sitemap');
    Route::get('sitemap/{sitemap?}', [HomeController::class, 'sitemapXML'])->name('sitemap');
    /**
     * Forgot password & login routes.
     */
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    /**
     *
     */
    Route::fallback(function () {
        return view('front.404');
    });

});

/**
 *  TESTING ROUTES
 */
Route::get('/phpinfo', function () {
    return phpinfo();
})->name('phpinfo');
