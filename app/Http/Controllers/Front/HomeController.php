<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Helpers\Recaptcha;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Mail\ContactFormMessage;
use App\Models\Front\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = Page::where('slug', 'homepage')->first();

        $page->description = Helper::setDescription($page->description);

        return view('front.page', compact('page'));
    }


    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function page(Page $page)
    {
        return view('front.page', compact('page'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact(Request $request)
    {
        return view('front.contact');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        // Recaptcha
        $recaptcha = (new Recaptcha())->check($request->toArray());

        if ( ! $recaptcha->ok()) {
            return back()->withErrors(['error' => 'ReCaptcha Error! Kontaktirajte administratora!']);
        }

        $message = $request->toArray();

        dispatch(function () use ($message) {
            Mail::to(config('mail.admin'))->send(new ContactFormMessage($message));
        });

        return view('front.contact')->with(['success' => 'Vaša poruka je uspješno poslana.! Odgovoriti ćemo vam uskoro.']);
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
            $size = 250;

            if ($request->has('size')) {
                $size = $request->input('size');
            }

            $image->make($request->input('src'))->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }, config('imagecache.lifetime'));

        return Image::make($cacheimage)->response();
    }

}
