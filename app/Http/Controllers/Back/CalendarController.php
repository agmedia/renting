<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Calendar\Calendar;
use App\Models\Back\Catalog\Product\ProductAction;
use App\Models\Back\Catalog\Product\ProductCategory;
use App\Models\Back\Catalog\Product\ProductImage;
use App\Models\Back\Catalog\Publisher;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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

        $calendars = $query->paginate(20)->appends(request()->query());

        if ($request->has('status')) {
            if ($request->input('status') == 'with_action' || $request->input('status') == 'without_action') {
                $calendars = collect();
                $temps = Calendar::all();

                if ($request->input('status') == 'with_action') {
                    foreach ($temps as $calendar) {
                        if ($calendar->special()) {
                            $calendars->push($calendar);
                        }
                    }
                }

                if ($request->input('status') == 'without_action') {
                    foreach ($temps as $calendar) {
                        if ( ! $calendar->special()) {
                            $calendars->push($calendar);
                        }
                    }
                }

                $calendars = $this->paginateColl($calendars);
            }
        }
        /*$authors    = Author::all()->pluck('title', 'id');
        $publishers = Publisher::all()->pluck('title', 'id');*/
        $counts = [];//Calendar::setCounts($query);

        return view('back.calendar.index', compact('calendars', 'counts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $calendar = new Calendar();

        $data = $calendar->getRelationsData();
        $active_actions = ProductAction::active()->get();

        return view('back.Calendar.edit', compact('data', 'active_actions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendar = new Calendar();

        $stored = $calendar->validateRequest($request)->create();

        if ($stored) {
            $calendar->checkSettings()
                    ->storeImages($stored);

            return redirect()->route('products.edit', ['Calendar' => $stored])->with(['success' => 'Artikl je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Calendar $calendar
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        $data = $calendar->getRelationsData();

        return view('back.catalog.Calendar.edit', compact('Calendar', 'data'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Calendar                  $calendar
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        $updated = $calendar->validateRequest($request)->edit();

        if ($updated) {
            $calendar->checkSettings()
                    ->storeImages($updated);

            $calendar->addHistoryData('change');

            return redirect()->route('products.edit', ['Calendar' => $updated])->with(['success' => 'Artikl je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Calendar $calendar)
    {
        ProductImage::where('product_id', $calendar->id)->delete();
        ProductCategory::where('product_id', $calendar->id)->delete();

        Storage::deleteDirectory(config('filesystems.disks.products.root') . $calendar->id);

        $destroyed = Calendar::destroy($calendar->id);

        if ($destroyed) {
            return redirect()->route('products')->with(['success' => 'Artikl je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
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
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
