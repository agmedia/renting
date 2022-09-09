<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Image;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\ApartmentDetail;
use App\Models\Back\Apartment\ApartmentImage;
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
    public function index(Request $request, Apartment $apartman)
    {
        $apartments = $apartman->paginate(20)->appends(request()->query());

        return view('back.apartment.index', compact('apartments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Apartment())->getEditViewData();
        $js_lang = json_encode(Lang::get('back/apartment'));

        return view('back.apartment.edit', compact('js_lang', 'data'));
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
            $apartment->storeImages();

            return redirect()->route('apartments.edit', ['apartman' => $stored])->with(['success' => 'Apartman je uspješno snimljen!']);
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
    public function edit(Apartment $apartman)
    {
        $data = $apartman->getEditViewData();
        $js_lang = json_encode(Lang::get('back/apartment'));
        $apartment = $apartman;

        //dd($data['images']);

        return view('back.apartment.edit', compact('apartment', 'js_lang', 'data'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Apartment                  $apartment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartman)
    {
        $updated = $apartman->validateRequest($request)->edit();
        $apartment = $apartman;

        if ($updated) {
            $updated->storeImages();

            return redirect()->route('apartments.edit', ['apartman' => $updated])->with(['success' => 'Apartment je uspješno snimljen!']);
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
    public function destroy(Request $request, Apartment $apartman)
    {
        /*ProductImage::where('product_id', $apartment->id)->delete();
        ProductCategory::where('product_id', $apartment->id)->delete();*/

        Storage::deleteDirectory(config('filesystems.disks.apartment.root') . $apartman->id);

        $destroyed = Apartment::destroy($apartman->id);

        if ($destroyed) {
            return redirect()->route('apartments')->with(['success' => 'Artikl je uspješno snimljen!']);
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

            Storage::deleteDirectory(config('filesystems.disks.apartment.root') . $id);

            $destroyed = Apartment::destroy($id);

            if ($destroyed) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Request $request)
    {
        if ($request->has('data')) {
            $image = ApartmentImage::find($request->input('data'));

            $deleted = $image->delete();

            if ($deleted) {
                $path = Image::cleanPath('apartment', $image->apartment_id, $image->image);
                Image::delete('apartment', $image->apartment_id, $path);

                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 400]);
    }
}
