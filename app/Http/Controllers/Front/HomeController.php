<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Front\Page;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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


    public function import()
    {
        $list = Excel::import(new ProductImport(), public_path('media/artikli.xlsx'));

        /*$spread = IOFactory::load(public_path('media/artikli.xlsx'));
        $sheet = $spread->getActiveSheet();
        $list = array(1,$sheet->toArray(null,true,true,true));*/

        dd($list);
    }

}
