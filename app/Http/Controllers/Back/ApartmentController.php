<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\ApartmentImage;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Orders\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Apartment $apartman)
    {
        $apartments = $apartman->filter($request)->with('translation')->paginate(20)->appends(request()->query());

        return view('back.apartment.index', compact('apartments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data    = (new Apartment())->getEditViewData();
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
            $stored->storeImages($request);

            return redirect()->route('apartments.edit', ['apartman' => $stored])->with(['success' => __('back/app.save_success')]);
        }

        return redirect()->back()->with(['error' => __('back/app.save_failure')]);
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
        $data      = $apartman->getEditViewData();
        $js_lang   = json_encode(Lang::get('back/apartment'));
        $apartment = $apartman;

        return view('back.apartment.edit', compact('apartment', 'js_lang', 'data'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Apartment                $apartment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartman)
    {
        $updated = $apartman->validateRequest($request)->edit();

        if ($updated) {
            $updated->storeImages();

            return redirect()->route('apartments.edit', ['apartman' => $updated])->with(['success' => __('back/app.save_success')]);
        }

        return redirect()->back()->with(['error' => __('back/app.save_failure')]);
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
        Storage::deleteDirectory(config('filesystems.disks.apartment.root') . $apartman->id);

        DB::table('option_to_apartment')->where('apartment_id', $apartman->id)->delete();

        $orders = Order::query()->where('apartment_id', $apartman->id)->get();

        foreach ($orders as $order) {
            DB::table('order_total')->where('order_id', $order->id)->delete();
            DB::table('order_history')->where('order_id', $order->id)->delete();
            DB::table('order_transactions')->where('order_id', $order->id)->delete();
        }

        Order::query()->where('apartment_id', $apartman->id)->delete();

        $destroyed = Apartment::destroy($apartman->id);

        if ($destroyed) {
            return redirect()->route('apartments')->with(['success' => __('back/app.save_success')]);
        }

        return redirect()->back()->with(['error' => __('back/app.save_failure')]);
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


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncURL(Request $request, Apartment $apartment)
    {
        $vali = Validator::make($request->toArray(), [
            'apartment' => 'required',
            'target'    => 'required',
            'url'       => 'required'
        ]);

        if ($vali->fails()) {
            return response()->json($vali->errors());
        }

        return $apartment->syncUrlWith($request);
    }


    /**
     * @param Apartment $apartman
     *
     * @return void
     */
    public function imageFix(Apartment $apartman)
    {
        $images = $apartman->images()->get();

        foreach ($images as $image) {
            $img = \Intervention\Image\Facades\Image::make($image->image);
            $new = [
                'image' => collect(['output' => [
                    'image' => \Intervention\Image\Facades\Image::make($img)->encode('data-url')->getEncoded()
                ]])->toJson(),
                'default' => intval($image->default)
            ];

            $image->setResource($apartman);
            $image->replace($image->id, $new);
        }

        $images = $apartman->images()->get();
        $existing = [];
        $all = Storage::disk('apartment')->allFiles($apartman->id);

        foreach ($images as $image) {
            $clean = Image::cleanPath('apartment', $apartman->id, $image->image);

            array_push($existing, $apartman->id . '/' . $clean);
            array_push($existing, $apartman->id . '/' . str_replace('.jpg', '.webp', $clean));
            array_push($existing, $apartman->id . '/' . str_replace('.jpg', '-thumb.webp', $clean));
        }

        foreach (array_diff($all, $existing) as $item) {
            Storage::disk('apartment')->delete($item);
        }

        return redirect()->back()->with(['success' => __('back/app.save_success')]);
    }
}
