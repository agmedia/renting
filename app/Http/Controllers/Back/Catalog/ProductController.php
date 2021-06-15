<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && ! empty($request->search)) {
            $products = Product::where('name', 'like', '%' . $request->search . '%')->paginate(12);
        } else {
            $products = Product::paginate(12);
        }

        return view('back.catalog.product.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();

        $data = $product->getRelationsData();

        return view('back.catalog.product.edit', compact('data'));
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
        $product = new Product();

        $stored = $product->validateRequest($request)->create();

        if ($stored) {
            $product->checkSettings()
                    ->storeImages($stored);

            return redirect()->route('products.edit', ['product' => $stored])->with(['success' => 'Product was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the product.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = $product->getRelationsData();

        return view('back.catalog.product.edit', compact('product', 'data'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product                  $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $updated = $product->validateRequest($request)->edit();

        if ($updated) {
            $product->checkSettings()
                    ->storeImages($updated);

            return redirect()->route('products.edit', ['product' => $updated])->with(['success' => 'Product was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the product.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $destroyed = Product::destroy($product->id);

        if ($destroyed) {
            return redirect()->route('products')->with(['success' => 'Product was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the product.']);
    }
}
