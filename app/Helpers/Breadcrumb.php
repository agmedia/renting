<?php


namespace App\Helpers;


use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Breadcrumb
{
    private $schema = [];

    private $breadcrumbs = [];

    public function __construct()
    {
        $this->setDefault();
    }


    public function category($group, Category $cat = null, $subcat = null)
    {
        if (isset($group) && $group) {
            $this->addGroup($group);

            if ($cat) {
                array_push($this->breadcrumbs, [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $cat->title,
                    'item' => route('catalog.route', ['group' => $group, 'cat' => $cat])
                ]);
            }

            if ($subcat) {
                array_push($this->breadcrumbs, [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $subcat->title,
                    'item' => route('catalog.route', ['group' => $group, 'cat' => $cat, 'subcat' => $subcat])
                ]);
            }
        }

        return $this;
    }


    public function product($group, Category $cat = null, $subcat = null, Product $prod = null)
    {
        $this->category($group, $cat, $subcat);

        if ($prod) {
            $count = count($this->breadcrumbs) + 1;

            array_push($this->breadcrumbs, [
                '@type' => 'ListItem',
                'position' => $count,
                'name' => $prod->name,
                'item' => url($prod->url)
            ]);
        }

        return $this;
    }


    public function resolve()
    {
        $this->schema['itemListElement'] = $this->breadcrumbs;

        return $this->schema;
    }


    private function setDefault()
    {
        $this->schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'BreadcrumbList'
        ];

        array_push($this->breadcrumbs, [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Naslovnica',
            'item' => route('index')
        ]);
    }


    public function addGroup($group)
    {
        array_push($this->breadcrumbs, [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => Str::ucfirst($group),
            'item' => route('catalog.route', ['group' => $group])
        ]);
    }
}
