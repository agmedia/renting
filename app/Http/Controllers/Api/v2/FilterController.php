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

        $author = $params['author'] ? Author::where('slug', $params['author'])->first() : null;
        $publisher = $params['publisher'] ? Publisher::where('slug', $params['publisher'])->first() : null;

        if ( ! $params['cat'] && ! $params['subcat']) {
            // Ako je normal kategorija
            if ($params['group']) {
                $categories = Cache::remember('category_list.' . $params['group'], config('cache.life'), function () use ($params) {
                    return Category::active()->topList($params['group'])->sortByName()->withCount('products')->get()->toArray();
                });

                $response = $this->resolveCategoryArray($categories, 'categories');
            }

            // Ako je autor
            if ( ! $params['group'] && $params['author']) {
                $a_cats = $author->categories();
                $response = $this->resolveCategoryArray($a_cats, 'author', $author);
            }

            // Ako je nakladnik
            if ( ! $params['group'] && $params['publisher']) {
                $a_cats = $publisher->categories();
                $response = $this->resolveCategoryArray($a_cats, 'publisher', $publisher);
            }
        }
        //
        if ($params['cat'] && ! $params['subcat']) {
            $cat = Category::where('id', $params['cat'])->first();

            if ($params['group']) {
                $item = Cache::remember('category_list.' . $cat['id'], config('cache.life'), function () use ($cat) {
                    return Category::active()->where('parent_id', $cat['id'])->sortByName()->withCount('products')->get()->toArray();
                });

                $response = $this->resolveCategoryArray($item, 'categories', null, $cat['slug']);
            }

            // Ako je autor
            if ( ! $params['group'] && $params['author']) {
                $a_cats = (new Author())->categories($cat['id']);
                $response = $this->resolveCategoryArray($a_cats, 'author', $author, $cat['slug']);
            }

            // Ako je nakladnik
            if ( ! $params['group'] && $params['publisher']) {
                $a_cats = (new Publisher())->categories($cat['id']);
                $response = $this->resolveCategoryArray($a_cats, 'publisher', $publisher, $cat['slug']);
            }
        }




        /*if ($params['group']) {
            if ( ! $params['cat'] && ! $params['subcat']) {
                $categories = Cache::remember('category_list.' . $params['group'], config('cache.life'), function () use ($params) {
                    return Category::active()->topList($params['group'])->sortByName()->withCount('products')->get()->toArray();
                });

                $response = $this->resolveCategoryArray($categories, 'categories');
            }

            //
            if ($params['cat'] && ! $params['subcat']) {
                $cat = Category::where('id', $params['cat'])->first();

                if ($cat) {
                    $item = Cache::remember('category_list.' . $cat['id'], config('cache.life'), function () use ($cat) {
                        return Category::active()->where('parent_id', $cat['id'])->sortByName()->withCount('products')->get()->toArray();
                    });

                    if ($item) {
                        $response = $this->resolveCategoryArray($item, 'categories', null, $cat['slug']);
                    }
                }
            }
        }

        if ( ! $params['group'] && $params['author']) {
            $author = Author::where('slug', $params['author'])->first();

            if ( ! $params['cat'] && ! $params['subcat']) {
                $a_cats = $author->categories();
                $response = $this->resolveCategoryArray($a_cats, 'author', $author);
            }

            if ($params['cat'] && ! $params['subcat']) {
                $cat = Category::where('id', $params['cat'])->first();
                $a_cats = (new Author())->categories($cat['id']);

                $response = $this->resolveCategoryArray($a_cats, 'author', $author, $cat['slug']);
            }
        }*/

        return response()->json($response);
    }


    private function resolveCategoryArray($categories, string $type, $target = null, string $parent_slug = null): array
    {
        $response = [];

        foreach ($categories as $category) {
            $url = $this->resolveCategoryUrl($category, $type, $target, $parent_slug);

            $response[] = [
                'id' => $category['id'],
                'title' => $category['title'],
                'count' => $category['products_count'],
                'url' => $url
            ];
        }

        return $response;
    }


    private function resolveCategoryUrl($category, string $type, $target, string $parent_slug = null): string
    {
        if ($type == 'author') {
            return route('catalog.route.author', [
                'author' => $target,
                'cat' => $parent_slug ?: $category['slug'],
                'subcat' => $parent_slug ? $category['slug'] : null
            ]);

        } elseif ($type == 'publisher') {
            return route('catalog.route.publisher', [
                'publisher' => $target,
                'cat' => $parent_slug ?: $category['slug'],
                'subcat' => $parent_slug ? $category['slug'] : null
            ]);

        } else {
            return route('catalog.route', [
                'group' => Str::slug($category['group']),
                'cat' => $parent_slug ?: $category['slug'],
                'subcat' => $parent_slug ? $category['slug'] : null
            ]);
        }
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(Request $request)
    {
        if ( ! $request->input('params')) {
            return response()->json(['status' => 300, 'message' => 'Error!']);
        }

        $params = $request->input('params');

        if (isset($params['autor']) && $params['autor']) {
            if (strpos($params['autor'], '+') !== false) {
                $arr = explode('+', $params['autor']);

                foreach ($arr as $item) {
                    $_author = Author::where('slug', $item)->first();
                    $this->authors[] = $_author;
                }
            } else {
                $_author = Author::where('slug', $params['autor'])->first();
                $this->authors[] = $_author;
            }
        }

        if (isset($params['nakladnik']) && $params['nakladnik']) {
            if (strpos($params['nakladnik'], '+') !== false) {
                $arr = explode('+', $params['nakladnik']);

                foreach ($arr as $item) {
                    $_publisher = Publisher::where('slug', $item)->first();
                    $this->publishers[] = $_publisher;
                }
            } else {
                $_publisher = Publisher::where('slug', $params['nakladnik'])->first();
                $this->publishers[] = $_publisher;
            }
        }

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
            $request_data['autor'] = $this->authors;
        }

        if (isset($params['nakladnik']) && $params['nakladnik']) {
            $request_data['nakladnik'] = $this->publishers;
        }

        if (isset($params['sort']) && $params['sort']) {
            $request_data['sort'] = $params['sort'];
        }

        $request = new Request($request_data);

        $products = (new Product())->filter($request)
                                   /*->basicData()*/
                                   ->with('author')
                                   ->paginate(config('settings.pagination.front'));

        return response()->json($products);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authors(Request $request)
    {
        if ($request->has('params')) {
            return response()->json(
                (new Author())->filter($request->input('params'))
                              ->basicData()
                              ->withCount('products')
                              ->get()
                              ->toArray()
            );
        }

        return response()->json(
            Author::query()->active()
                           ->featured()
                           ->basicData()
                           ->withCount('products')
                           ->get()
                           ->toArray()
        );
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishers(Request $request)
    {
        if ($request->has('params')) {
            return response()->json(
                (new Publisher())->filter($request->input('params'))
                                 ->basicData()
                                 ->withCount('products')
                                 ->get()
                                 ->toArray()
            );
        }

        return response()->json(
            Publisher::active()
                     ->featured()
                     ->basicData()
                     ->withCount('products')
                     ->get()
                     ->toArray()
        );
    }

}
