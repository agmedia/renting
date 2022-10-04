<?php

namespace App\Models;

use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Page;
use App\Models\Front\Catalog\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class Sitemap
 * @package App\Models
 */
class Sitemap
{

    /**
     * @var string|null
     */
    private $sitemap;

    /**
     * @var array
     */
    private $response = [];


    /**
     * Sitemap constructor.
     *
     * @param string|null $sitemap
     */
    public function __construct(string $sitemap = null)
    {
        $this->sitemap = $sitemap ? $this->setSitemap($sitemap) : null;
    }


    /**
     * @return string|null
     */
    public function getSitemap()
    {
        return $this->sitemap;
    }


    /**
     * @param string $sitemap
     *
     * @return array
     */
    private function setSitemap(string $sitemap)
    {
        if ($sitemap == 'pages' || $sitemap == 'pages.xml') {
            return $this->getPages();
        }

        if ($sitemap == 'categories' || $sitemap == 'categories.xml') {
            return $this->getCategories();
        }

        if ($sitemap == 'products' || $sitemap == 'products.xml') {
            return $this->getProducts();
        }

    }


    /**
     * @return array
     */
    private function getPages()
    {
        $pages = Page::query()->where('group', 'page')->where('slug', '!=', 'homepage')->where('status', '=', 1)->select('slug', 'status', 'updated_at')->get();
        $blogs = Page::query()->where('group', 'blog')->where('status', '=', 1)->select('slug', 'status', 'updated_at')->get();

        $this->response[] = [
            'url' => route('index'),
            'lastmod' => Carbon::now()->startOfMonth()->tz('UTC')->toAtomString()
        ];

        $this->response[] = [
            'url' => route('kontakt'),
            'lastmod' => Carbon::now()->startOfYear()->tz('UTC')->toAtomString()
        ];

        $this->response[] = [
            'url' => route('faq'),
            'lastmod' => Carbon::now()->startOfYear()->tz('UTC')->toAtomString()
        ];

        foreach ($pages as $page) {
            $this->response[] = [
                'url' => route('catalog.route.page', ['page' => $page->slug]),
                'lastmod' => $page->updated_at->tz('UTC')->toAtomString()
            ];
        }

        foreach ($blogs as $blog) {
            $this->response[] = [
                'url' => route('catalog.route.blog', ['blog' => $blog->slug]),
                'lastmod' => $blog->updated_at->tz('UTC')->toAtomString()
            ];
        }

        //dd($coll);

        return $this->response;
    }


    /**
     * @return array
     */
    private function getCategories()
    {
        $categories = Category::query()->active()->topList()->with('subcategories')->get();

        foreach ($categories as $category) {
            $this->response[] = [
                'url' => route('catalog.route', ['group' => Str::slug($category->group), 'cat' => $category->slug]),
                'lastmod' => $category->updated_at->tz('UTC')->toAtomString()
            ];

            foreach ($category->subcategories()->get() as $subcategory) {
                $this->response[] = [
                    'url' => route('catalog.route', ['group' => Str::slug($category->group), 'cat' => $category->slug, 'subcat' => $subcategory->slug]),
                    'lastmod' => $subcategory->updated_at->tz('UTC')->toAtomString()
                ];
            }
        }

        return $this->response;
    }


    /**
     * @return array
     */
    private function getProducts()
    {
        $products = Product::query()->active()->hasStock()->select('url', 'updated_at')->get();

        foreach ($products as $product) {
            $this->response[] = [
                'url' => url($product->url),
                'lastmod' => $product->updated_at->tz('UTC')->toAtomString()
            ];
        }

        return $this->response;
    }


}
