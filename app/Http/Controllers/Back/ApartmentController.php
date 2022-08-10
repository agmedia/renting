<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\System\Category;
use App\Models\Back\Apartment\Apartment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Apartment $apartment)
    {
        $query = $apartment->filter($request);

        $apartments = $query->paginate(20)->appends(request()->query());

        /*if ($request->has('status')) {
            if ($request->input('status') == 'with_action' || $request->input('status') == 'without_action') {
                $apartments = collect();
                $temps = Apartment::all();

                if ($request->input('status') == 'with_action') {
                    foreach ($temps as $apartment) {
                        if ($apartment->special()) {
                            $apartments->push($apartment);
                        }
                    }
                }

                if ($request->input('status') == 'without_action') {
                    foreach ($temps as $apartment) {
                        if ( ! $apartment->special()) {
                            $apartments->push($apartment);
                        }
                    }
                }

                $apartments = $this->paginateColl($apartments);
            }
        }*/

        $categories = (new Category())->getList(false);


        /*$authors    = Author::all()->pluck('title', 'id');
        $publishers = Publisher::all()->pluck('title', 'id');*/
        $counts = [];//Apartment::setCounts($query);

        return view('back.apartment.index', compact('apartments', 'categories'/*, 'authors', 'publishers'*/, 'counts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartment = new Apartment();

        return view('back.apartment.edit'/*, compact('data')*/);
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
        $apartment = new Apartment();

        $stored = $apartment->validateRequest($request)->create();

        if ($stored) {
            /*$apartment->checkSettings()
                    ->storeImages($stored);*/

            return redirect()->route('products.edit', ['Apartment' => $stored])->with(['success' => 'Artikl je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Ops..! Greška prilikom snimanja.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Apartment $apartment
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        //$data = $apartment->getRelationsData();

        return view('back.catalog.Apartment.edit', compact('apartment'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Apartment                  $apartment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $updated = $apartment->validateRequest($request)->edit();

        if ($updated) {
            /*$apartment->checkSettings()
                    ->storeImages($updated);

            $apartment->addHistoryData('change');*/

            return redirect()->route('products.edit', ['Apartment' => $updated])->with(['success' => 'Artikl je uspješno snimljen!']);
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
    public function destroy(Request $request, Apartment $apartment)
    {
        /*ProductImage::where('product_id', $apartment->id)->delete();
        ProductCategory::where('product_id', $apartment->id)->delete();*/

        Storage::deleteDirectory(config('filesystems.disks.products.root') . $apartment->id);

        $destroyed = Apartment::destroy($apartment->id);

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
            
            /*ProductImage::where('product_id', $id)->delete();
            ProductCategory::where('product_id', $id)->delete();*/

            Storage::deleteDirectory(config('filesystems.disks.products.root') . $id);

            $destroyed = Apartment::destroy($id);

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
