<?php

namespace App\Http\Controllers\Back\Settings\App;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Faq;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = LanguageHelper::adminList();
        $main = $items->where('main', 1)->first();

        return view('back.settings.app.languages', compact('items', 'main'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *val
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cache::forget('lang_list');

        return Settings::storeList($request);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMain(Request $request)
    {
        Cache::forget('lang_list');

        $data = $request->data;

        $setting = Settings::where('code', 'language')->where('key', 'list')->first();

        $values = collect();

        if ($setting) {
            $values = collect(json_decode($setting->value));
        }

        if (isset($data['main'])) {
            $values->where('id', intval($data['main']))->map(function ($item) use ($data) {
                $item->main = true;

                return $item;
            });

            $values->where('id', '!=', intval($data['main']))->map(function ($item) use ($data) {
                $item->main = false;

                return $item;
            });
        }

        $stored = Settings::edit($setting->id, 'language', 'list', $values->toJson(), true);

        if ($stored) {
            return response()->json(['success' => 'Glavni jezik je uspješno izmjenjen.']);
        }

        return response()->json(['message' => 'Whoops.!! Pokušajte ponovo ili kontaktirajte administratora!']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Cache::forget('lang_list');

        $data = $request->data;

        if ($data['id']) {
            $setting = Settings::where('code', 'language')->where('key', 'list')->first();

            $values = collect(json_decode($setting->value));

            $new_values = $values->reject(function ($item) use ($data) {
                return $item->id == $data['id'];
            });

            $stored = Settings::edit($setting->id, 'language', 'list', $new_values->toJson(), true);
        }

        if ($stored) {
            return response()->json(['success' => 'Jezik je uspješno obrisan.']);
        }

        return response()->json(['message' => 'Whoops.!! Pokušajte ponovo ili kontaktirajte administratora!']);
    }
}
