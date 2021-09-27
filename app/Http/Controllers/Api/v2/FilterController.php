<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Front\Catalog\Product;
use App\Models\Back\Catalog\Product\ProductImage;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilterController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        if ( ! $request->input('params')) {
            return response()->json(['status' => 300, 'message' => 'Error!']);
        }

        $response = [];
        $params = $request->input('params');

        if ($params['group']) {
            if ( ! $params['cat'] && ! $params['subcat']) {
                $response = [];
                $categories = Cache::remember('category_list.' . $params['group'], config('cache.life'), function () use ($params) {
                    return Category::where('group', $params['group'])->where('parent_id', 0)->sortByName()->with('subcategories')->withCount('products')->get()->toArray();
                });

                foreach ($categories as $category) {
                    $response[] = [
                        'id' => $category['id'],
                        'title' => $category['title'],
                        'count' => $category['products_count'],
                        'url' => route('catalog.route', ['group' => Str::slug($category['group']), 'cat' => $category['slug']])
                        //'url' => Str::slug($category['group']) . '/' . $category['slug']
                    ];
                }
            }

            //
            if ($params['cat'] && ! $params['subcat']) {
                $cat = Category::where('id', $params['cat'])->first();

                if ($cat) {
                    $item = Cache::remember('category_list.' . $cat->id, config('cache.life'), function () use ($cat) {
                        return Category::where('parent_id', $cat->id)->sortByName()->with('subcategories')->withCount('products')->get()->toArray();
                    });

                    if ($item) {
                        $response = [];

                        foreach ($item as $category) {
                            $response[] = [
                                'id' => $category['id'],
                                'title' => $category['title'],
                                'count' => $category['products_count'],
                                'url' => route('catalog.route', ['group' => Str::slug($category['group']), 'cat' => $cat['slug'], 'subcat' => $category['slug']])
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }


    public function products(Request $request)
    {
        if ( ! $request->input('params')) {
            return response()->json(['status' => 300, 'message' => 'Error!']);
        }

        $params = $request->input('params');

        /*if (isset($params['autor']) && $params['autor']) {
            if (strpos($params['autor'], ',') !== false) {
                $arr = explode(',', $params['autor']);

                foreach ($arr as $item) {
                    $_author = Author::where('slug', $item)->first();
                    $this->authors[] = $_author;
                }
            } else {
                $_author = Author::where('slug', $params['autor'])->first();
                $this->authors[] = $_author;
            }
        }

        if ($request->has('nakladnik')) {
            $nak = $request->input('nakladnik');

            if (strpos($nak, ',') !== false) {
                $arr = explode(',', $nak);

                foreach ($arr as $item) {
                    $_publisher = Publisher::where('slug', $item)->first();
                    $this->publishers[] = $_publisher;
                }
            } else {
                $_publisher = Publisher::where('slug', $nak)->first();
                $this->publishers[] = $_publisher;
            }
        }*/

        $request_data = [];

        if (isset($params['start']) && $params['start']) {
            $request_data['start'] = $params['start'];
        }

        if (isset($params['end']) && $params['end']) {
            $request_data['end'] = $params['end'];
        }

        if (isset($params['group']) && $params['group']) {
            $request_data['group'] = $params['group'];
        }

        if (isset($params['cat']) && $params['cat']) {
            $request_data['cat'] = $params['cat'];
        }

        if (isset($params['subcat']) && $params['subcat']) {
            $request_data['subcat'] = $params['subcat'];
        }

        if (isset($params['autor']) && $params['autor']) {
            $request_data['autor'] = $params['autor'];
        }

        if (isset($params['nakladnik']) && $params['nakladnik']) {
            $request_data['nakladnik'] = $params['nakladnik'];
        }

        $request = new Request($request_data);

        $products = (new Product())->filter($request)->with('author')->paginate(config('settings.pagination.front'));

        return response()->json($products);
    }

}
