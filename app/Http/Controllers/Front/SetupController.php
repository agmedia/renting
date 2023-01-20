<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Currency;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class SetupController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setMainCurrency(Request $request)
    {
        if ($request->has('currency')) {
            //CurrencyHelper::mainSession($request->input('currency'));
            Currency::session($request->input('currency'));
        }

        return redirect()->back();
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function imageCache(Request $request)
    {
        $src = $request->input('src');

        $cacheimage = Image::cache(function($image) use ($src) {
            $image->make($src);
        }, config('imagecache.lifetime'));

        return Image::make($cacheimage)->response();
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function thumbCache(Request $request)
    {
        if ( ! $request->has('src')) {
            return asset('media/img/knjiga-detalj.jpg');
        }

        $cacheimage = Image::cache(function($image) use ($request) {
            $width = 250;
            $height = 300;

            if ($request->has('size')) {
                if (strpos($request->input('size'), 'x') !== false) {
                    $size = explode('x', $request->input('size'));
                    $width = $size[0];
                    $height = $size[1];
                }
            } else {
                $width = $request->input('size');
            }

            $image->make($request->input('src'))->resize($width, $height);

        }, config('imagecache.lifetime'));

        return Image::make($cacheimage)->response();
    }


    /**
     * @param Request $request
     * @param null    $sitemap
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemapXML(Request $request, $sitemap = null)
    {
        if ( ! $sitemap) {
            $items = config('settings.sitemap');

            return response()->view('front.layouts.partials.sitemap-index', [
                'items' => $items
            ])->header('Content-Type', 'text/xml');
        }

        $sm = new Sitemap($sitemap);

        return response()->view('front.layouts.partials.sitemap', [
            'items' => $sm->getSitemap()
        ])->header('Content-Type', 'text/xml');
    }

}
