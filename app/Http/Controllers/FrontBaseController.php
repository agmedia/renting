<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Front\Catalog\Page;
use Illuminate\Support\Facades\View;

class FrontBaseController extends Controller
{

    public function __construct()
    {
        $pages = Page::with('translation')->get();
        View::share('pages', $pages);
    }

}
