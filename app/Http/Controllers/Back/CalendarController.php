<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Calendar\Calendar;
use App\Models\Back\Catalog\Product\ProductAction;
use App\Models\Back\Catalog\Product\ProductCategory;
use App\Models\Back\Catalog\Product\ProductImage;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Orders\Order;
use App\Models\Front\Checkout\Checkout;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Calendar $calendar)
    {
        $query = $calendar->filter($request);
        $calendars = $query->with('apartment')->get()/*->appends(request()->query())*/;
        $calendars = Helper::getCalendarBackViewData($calendars);
        $apartments = Apartment::query()->where('status', 1)->get();
        $counts = [];

        return view('back.calendar.index', compact('calendars', 'apartments', 'counts'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        if ( ! isset($request['data']['extendedProps']['order']['id'])) {
            if (isset($request['data']['type']) && $request['data']['type'] == 'service') {
                return $this->storeService($request);
            }

            response()->json(['error' => 300, 'message' => __('back/app.save_failure')]);
        }

        $calendar = new Calendar();
        $updated  = $calendar->updateOrder($request);

        if ($updated) {
            return response()->json(['success' => 200, 'message' => __('back/app.save_success')]);
        }

        return response()->json(['error' => 300, 'message' => __('back/app.save_failure')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Calendar $calendar
     *
     * @return \Illuminate\Http\Response
     */
    public function storeService(Request $request)
    {
        $calendar = new Calendar();
        $updated  = $calendar->storeServiceOrder($request);

        if ($updated) {
            return response()->json(['success' => 200, 'message' => __('back/app.save_success')]);
        }

        return response()->json(['error' => 300, 'message' => __('back/app.save_failure')]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyApi(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');

            ProductImage::where('product_id', $id)->delete();
            ProductCategory::where('product_id', $id)->delete();

            Storage::deleteDirectory(config('filesystems.disks.products.root') . $id);

            $destroyed = Calendar::destroy($id);

            if ($destroyed) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }


    /**
     * @param       $items
     * @param int   $perPage
     * @param null  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginateColl($items, $perPage = 20, $page = null, $options = []): LengthAwarePaginator
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
