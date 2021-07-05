<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CatalogRouteController extends Controller
{
    /**
     * Resolver for the Groups, categories and products routes.
     * Route::get('{group}/{cat?}/{subcat?}/{prod?}', 'Front\GCP_RouteController::resolve()')->name('gcp_route');
     *
     * @param               $group
     * @param Category|null $cat
     * @param Category|null $subcat
     * @param Product|null  $prod
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resolve(Request $request, $group, Category $cat = null, Category $subcat = null, Product $prod = null)
    {
        $ids = collect();

        // If only group...
        if ( ! $cat && ! $subcat && ! $prod) {
            $categories = Category::where('group', $group)->with('subcategories')->get();

            foreach ($categories as $category) {
                $ids = $ids->merge($category->products()->pluck('id'));
            }

            //dd($categories, $ids->unique());

            $products = Product::whereIn('id', $ids->unique())->paginate(18);
        }

        //dd($products);

        return view('front.catalog.category.index', compact('group', 'cat', 'subcat', 'products'));
    }


    /**
     * @param Author $author
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function author(Author $author)
    {
        if ( ! $author) {
            $authors = Author::all();

            return view('front.catalog.authors.index', compact('authors'));
        }

        $products = Product::where('author_id', $author->id)->paginate(18);

        return view('front.catalog.authors.index', compact('author', 'products'));
    }


    /**
     * @param Publisher $publisher
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function publisher(Publisher $publisher)
    {
        if ( ! $publisher) {
            $publishers = Publisher::all();

            return view('front.catalog.publishers.index', compact('publishers'));
        }

        $products = Product::where('publisher_id', $publisher->id)->paginate(18);

        return view('front.catalog.publishers.index', compact('publisher', 'products'));
    }
    
}
