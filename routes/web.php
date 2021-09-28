<?php

use App\Http\Controllers\Api\v2\CartController;
use App\Http\Controllers\Api\v2\FilterController;
use App\Http\Controllers\Back\Catalog\AuthorController;
use App\Http\Controllers\Back\Catalog\CategoryController;
use App\Http\Controllers\Back\Catalog\ProductController;
use App\Http\Controllers\Back\Catalog\PublisherController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\Marketing\ActionController;
use App\Http\Controllers\Back\Marketing\BlogController;
use App\Http\Controllers\Back\Settings\App\GeoZoneController;
use App\Http\Controllers\Back\Settings\App\OrderStatusController;
use App\Http\Controllers\Back\Settings\App\PaymentController;
use App\Http\Controllers\Back\Settings\App\ShippingController;
use App\Http\Controllers\Back\Settings\App\TaxController;
use App\Http\Controllers\Back\Settings\FaqController;
use App\Http\Controllers\Back\Settings\PageController;
use App\Http\Controllers\Back\Settings\QuickMenuController;
use App\Http\Controllers\Back\Settings\SettingsController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\Widget\WidgetController;
use App\Http\Controllers\Back\Widget\WidgetGroupController;
use App\Http\Controllers\Front\CatalogRouteController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;


/*Route::domain('https://images.antikvarijatbibl.lin73.host25.com/')->group(function () {
    Route::get('media/img/products/{id}/{image}', function ($id, $image) {
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
 * BACK ROUTES
 */
Route::middleware(['auth:sanctum', 'verified', 'no.customers'])->prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('setRoles', [DashboardController::class, 'setRoles'])->name('roles.set');
    Route::get('import', [DashboardController::class, 'import'])->name('import.initial');
    Route::get('mailing-test', [DashboardController::class, 'mailing'])->name('mailing.test');

    Route::get('letters', [DashboardController::class, 'letters'])->name('letters.import');
    Route::get('slugs', [DashboardController::class, 'slugs'])->name('slugs.revision');
    Route::get('statuses', [DashboardController::class, 'statuses'])->name('statuses.cron');

    // CATALOG
    Route::prefix('catalog')->group(function () {
        // KATEGORIJE
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::patch('category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

        // IZDAVAČI
        Route::get('publishers', [PublisherController::class, 'index'])->name('publishers');
        Route::get('publisher/create', [PublisherController::class, 'create'])->name('publishers.create');
        Route::post('publisher', [PublisherController::class, 'store'])->name('publishers.store');
        Route::get('publisher/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
        Route::patch('publisher/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
        Route::delete('publisher/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

        // AUTORI
        Route::get('authors', [AuthorController::class, 'index'])->name('authors');
        Route::get('author/create', [AuthorController::class, 'create'])->name('authors.create');
        Route::post('author', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('author/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::patch('author/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('author/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

        // ARTIKLI
        Route::get('products', [ProductController::class, 'index'])->name('products');
        Route::get('product/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('product', [ProductController::class, 'store'])->name('products.store');
        Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('product/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // NARUDŽBE
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('order/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('order/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('order/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('order/{order}', [OrderController::class, 'update'])->name('orders.update');

    // MARKETING
    Route::prefix('marketing')->group(function () {
        // AKCIJE
        Route::get('actions', [ActionController::class, 'index'])->name('actions');
        Route::get('action/create', [ActionController::class, 'create'])->name('actions.create');
        Route::post('action', [ActionController::class, 'store'])->name('actions.store');
        Route::get('action/{action}/edit', [ActionController::class, 'edit'])->name('actions.edit');
        Route::patch('action/{action}', [ActionController::class, 'update'])->name('actions.update');
        Route::delete('action/{action}', [ActionController::class, 'destroy'])->name('actions.destroy');

        // BLOG
        Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
        Route::get('blog/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('blog', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('blog/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    });

    // KORISNICI
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('user', [UserController::class, 'store'])->name('users.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('user/{user}', [UserController::class, 'update'])->name('users.update');

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

    // POSTAVKE
    Route::prefix('settings')->group(function () {
        // INFO PAGES
        Route::get('pages', [PageController::class, 'index'])->name('pages');
        Route::get('page/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('page', [PageController::class, 'store'])->name('pages.store');
        Route::get('page/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::patch('page/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('page/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

        // FAQ
        Route::get('faqs', [FaqController::class, 'index'])->name('faqs');
        Route::get('faq/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('faq', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
        Route::patch('faq/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

        //Route::get('application', [SettingsController::class, 'index'])->name('settings');

        Route::prefix('application')->group(function () {
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
            Route::get('shippings', [ShippingController::class, 'index'])->name('shippings');
            Route::get('payments', [PaymentController::class, 'index'])->name('payments');
            Route::get('taxes', [TaxController::class, 'index'])->name('taxes');
        });
    });

    // SETTINGS
    Route::get('/clean/cache', [QuickMenuController::class, 'cache'])->name('cache');
    Route::get('maintenance/on', [QuickMenuController::class, 'maintenanceModeON'])->name('maintenance.on');
    Route::get('maintenance/off', [QuickMenuController::class, 'maintenanceModeOFF'])->name('maintenance.off');
});

/**
 * CUSTOMER BACK ROUTES
 */
Route::middleware(['auth:sanctum', 'verified'])->prefix('moj-racun')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('moj-racun');
    Route::patch('/snimi/{user}', [CustomerController::class, 'save'])->name('moj-racun.snimi');
    Route::get('/narudzbe', [CustomerController::class, 'orders'])->name('moje-narudzbe');
});

/**
 * API Routes
 */
Route::prefix('api/v2')->group(function () {
    // SEARCH
    Route::get('pretrazi', [CatalogRouteController::class, 'search'])->name('api.front.search');
    // CART
    Route::prefix('cart')->group(function () {
        Route::get('/get', [CartController::class, 'get']);
        Route::post('/add', [CartController::class, 'add']);
        Route::post('/update/{id}', [CartController::class, 'update']);
        Route::get('/remove/{id}', [CartController::class, 'remove']);
        Route::get('/coupon/{coupon}', [CartController::class, 'coupon']);;
    });

    Route::get('/products/autocomplete', [\App\Http\Controllers\Api\v2\ProductController::class, 'autocomplete'])->name('products.autocomplete');
    Route::post('/products/image/delete', [\App\Http\Controllers\Api\v2\ProductController::class, 'destroyImage'])->name('products.destroy.image');

    // FILTER
    Route::prefix('filter')->group(function () {
        Route::post('/getCategories', [FilterController::class, 'categories']);
        Route::post('/getProducts', [FilterController::class, 'products']);
    });

    // SETTINGS
    Route::prefix('settings')->group(function () {
        // WIDGET
        Route::prefix('widget')->group(function () {
            Route::post('destroy', [WidgetController::class, 'destroy'])->name('widget.destroy');
            Route::get('get-links', [WidgetController::class, 'getLinks'])->name('widget.api.get-links');
        });
        // APPLICATION SETTINGS
        Route::prefix('app')->group(function () {
            // GEO ZONE
            /*Route::prefix('geo-zone')->group(function () {
                Route::post('get-state-zones', 'Back\Settings\Store\GeoZoneController@getStateZones')->name('geo-zone.get-state-zones');
                Route::post('store', 'Back\Settings\Store\GeoZoneController@store')->name('geo-zone.store');
                Route::post('destroy', 'Back\Settings\Store\GeoZoneController@destroy')->name('geo-zone.destroy');
            });*/
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
            // TOTALS
            /*Route::prefix('totals')->group(function () {
                Route::post('store', 'Back\Settings\Store\TotalController@store')->name('totals.store');
                Route::post('destroy', 'Back\Settings\Store\TotalController@destroy')->name('totals.destroy');
            });*/
        });
    });
});

Route::get('/phpinfo', function () {
    return phpinfo();
})->name('index');

/**
 * FRONT ROUTES
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/kontakt', [HomeController::class, 'contact'])->name('kontakt');
Route::post('/kontakt/posalji', [HomeController::class, 'sendContactMessage'])->name('poruka');
Route::get('/faq', [CatalogRouteController::class, 'faq'])->name('faq');

Route::get('/kosarica', [CheckoutController::class, 'cart'])->name('kosarica');
Route::get('/naplata', [CheckoutController::class, 'checkout'])->name('naplata');
Route::get('/pregled', [CheckoutController::class, 'view'])->name('pregled');
Route::get('/narudzba', [CheckoutController::class, 'order'])->name('checkout');

Route::get('/uspjeh', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/greska', [CheckoutController::class, 'error'])->name('checkout.error');

Route::get('pretrazi', [CatalogRouteController::class, 'search'])->name('pretrazi');

Route::get('info/{page}', [CatalogRouteController::class, 'page'])->name('catalog.route.page');
Route::get('blog/{blog?}', [CatalogRouteController::class, 'blog'])->name('catalog.route.blog');
//
Route::get('cache/image', [HomeController::class, 'imageCache']);
Route::get('cache/thumb', [HomeController::class, 'thumbCache']);
/*
 * Groups, Categories and Products routes resolver.
 * https://www.antikvarijat-biblos.hr/kategorija-proizvoda/knjige/
 */
Route::get('proizvod/{prod?}/', [CatalogRouteController::class, 'resolveOldUrl']);
Route::get('kategorija-proizvoda/{group?}/{cat?}/{subcat?}', [CatalogRouteController::class, 'resolveOldCategoryUrl']);
//
Route::get(config('settings.author_path') . '/{author?}/{cat?}/{subcat?}', [CatalogRouteController::class, 'author'])->name('catalog.route.author');
Route::get(config('settings.publisher_path') . '/{publisher?}/{cat?}/{subcat?}', [CatalogRouteController::class, 'publisher'])->name('catalog.route.publisher');
//
Route::get('snizenja/{cat?}/{subcat?}', [CatalogRouteController::class, 'actions'])->name('catalog.route.actions');
//
Route::get('{group}/{cat?}/{subcat?}/{prod?}', [CatalogRouteController::class, 'resolve'])->name('catalog.route');


Route::fallback(function () {
    return view('front.404');
});
