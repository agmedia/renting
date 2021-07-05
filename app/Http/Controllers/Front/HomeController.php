<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
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
        return view('front.home');
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
