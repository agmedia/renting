<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
    public function resolve(Request $request, $group, Category $cat = null, $subcat = null, Product $prod = null)
    {
        //
        if ($subcat) {
            $sub_category = Category::where('slug', $subcat)->where('parent_id', $cat->id)->first();

            if ( ! $sub_category) {
                $prod = Product::where('slug', $subcat)->first();
            }

            $subcat = $sub_category;
        }

        // Check if there is Product set.
        if ($prod) {
            return view('front.catalog.product.index', compact('prod', 'group', 'cat', 'subcat'));
        }

        $ids = collect();

        // If only group...
        if ($group && ! $cat && ! $subcat) {
            $categories = Category::where('group', $group)->with('subcategories')->get();

            foreach ($categories as $category) {
                $ids = $ids->merge($category->products()->pluck('id'));
            }
        }

        // If only group and category...
        if ($cat && ! $subcat) {
            $category = Category::where('group', $group)->where('id', $cat->id)->with('subcategories')->first();

            $ids = $ids->merge($category->products()->pluck('id'));
        }

        // If only group, category and subcategory...
        if ($cat && $subcat) {
            $category = Category::where('group', $group)->where('parent_id', $cat->id)->where('id', $subcat->id)->first();

            $ids = $ids->merge($category->products()->pluck('id'));
        }

        $products = (new Product())->filter($request, $ids)->paginate(6);

        //dd($products);

        return view('front.catalog.category.index', compact('group', 'cat', 'subcat', 'products'));
    }


    /**
     * @param Author $author
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function author(Request $request, Author $author = null)
    {
        $letters = Author::letters();
        $letter = $this->checkLetter($letters);

        if ($request->has('letter')) {
            $letter = $request->input('letter');
        }

        if ( ! $author) {
            $authors = Author::where('title', 'LIKE', $letter . '%')->get();

            return view('front.catalog.authors.index', compact('authors', 'letters', 'letter'));
        }

        $products = Product::where('author_id', $author->id)->active()->paginate(18);

        $group = null;
        $cat = null;
        $subcat = null;

        return view('front.catalog.category.index', compact('author', 'products', 'letter', 'group', 'cat', 'subcat'));
    }


    /**
     * @param Publisher $publisher
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function publisher(Request $request, Publisher $publisher = null)
    {
        $letters = Publisher::letters();
        $letter = $this->checkLetter($letters);

        if ($request->has('letter')) {
            $letter = $request->input('letter');
        }

        if ( ! $publisher) {
            $publishers = Publisher::where('title', 'LIKE', $letter . '%')->get();

            return view('front.catalog.publishers.index', compact('publishers', 'letters', 'letter'));
        }

        $products = Product::where('publisher_id', $publisher->id)->active()->paginate(18);

        //dd($products);

        $group = null;
        $cat = null;
        $subcat = null;

        return view('front.catalog.category.index', compact('publisher', 'products', 'letter', 'group', 'cat', 'subcat'));
    }


    /**
     * @param array $letters
     *
     * @return string
     */
    private function checkLetter(Collection $letters): string
    {
        foreach ($letters->all() as $letter) {
            if ($letter['active']) {
                return $letter['value'];
            }
        }

        return 'A';
    }

}
