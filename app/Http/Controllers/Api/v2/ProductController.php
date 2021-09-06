<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Product\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Request $request)
    {
        $image = ProductImage::where('id', $request->input('data'))->first();
        $path = str_replace(config('filesystems.disks.products.url'), '', $image->image);
        // Obriši staru sliku
        Storage::disk('products')->delete($path);

        if (ProductImage::where('id', $request->input('data'))->delete()) {
            ProductImage::where('image', $image->image)->delete();

            return response()->json(['success' => 200]);
        }

        return response()->json(['error' => 400]);
    }
}
