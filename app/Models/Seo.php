<?php

namespace App\Models;

use App\Models\Back\Orders\Order;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;

/**
 * Class Sitemap
 * @package App\Models
 */
class Seo
{

    /**
     * @param Product $product
     *
     * @return string[]
     */
    public static function getProductData(Product $product): array
    {
        return [
            'title'       => $product->name . ' knjige ' . (isset($product->author->title) ? $product->author->title : ''),
            'description' => 'Knjiga ' . $product->name . ' izdavača ' . (isset($product->author->title) ? $product->author->title : '') . ' godine izdanja ' . ($product->year ?: '') . ' i mjesta izdavanja ' . ($product->origin ?: '') . ' u Antikvarijatu Biblos.'
        ];
    }


    /**
     * @param Order $order
     *
     * @return array
     */
    public static function getGoogleDataLayer(Order $order)
    {
        $products = [];

        foreach ($order->products as $product) {
            $category = '';
            $p = $product->real;

            if ($p->category()) { $category = $p->category()->title; }
            if ($p->subcategory()) { $category = $p->subcategory()->title; }

            $products[] = [
                'sku' => $p->sku,
                'name' => $product->name,
                'category' => $category,
                'price' => $product->price,
                'quantity' => $product->quantity
            ];
        }

        $data = [
            'event' => 'orderComplete',
            'transactionId' => $order->id,
            'transactionAffiliation' => 'AntikvarijatBiblos',
            'transactionTotal' => $order->total,
            'transactionTax' => 0,
            'transactionShipping' => 0,
            'transactionProducts' => $products
        ];

        return $data;
    }


}
