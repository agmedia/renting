<?php

namespace App\Http\Controllers\Back;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\ApartmentDetail;
use App\Models\Back\Marketing\Gallery\Gallery;
use App\Models\Back\Settings\System\Category;
use App\Models\Back\Apartment\Apartment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
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
        $apartments = $apartment->paginate(20)->appends(request()->query());

        return view('back.apartment.index', compact('apartments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $amenities = collect(config('settings.apartment_details'))->groupBy('group');
        $js_lang = json_encode(Lang::get('back/apartment'));
        $favorites = [];//ApartmentDetail::all();
        $galleries = Gallery::adminSelectList();

        //dd($galleries);

        return view('back.apartment.edit', compact('amenities', 'favorites', 'galleries', 'js_lang'));
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

            return redirect()->route('apartments.edit', ['apartment' => $stored])->with(['success' => 'Apartman je uspješno snimljen!']);
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

        $amenities = collect(config('settings.apartment_details'))->groupBy('group');
        $js_lang = json_encode(Lang::get('back/apartment'));
        $favorites = [];//ApartmentDetail::all();
        $galleries = Gallery::adminSelectList();

        return view('back.apartment.edit', compact('apartment', 'amenities', 'favorites', 'galleries', 'js_lang'));
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
