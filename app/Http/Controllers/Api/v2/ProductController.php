<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Back\Catalog\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $query = (new Product())->newQuery();

        if ($request->has('query')) {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
        }

        $products = $query->get();

        return response()->json($products);
    }
}
