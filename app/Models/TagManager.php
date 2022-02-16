<?php

namespace App\Models;

use App\Models\Back\Orders\Order;

/**
 * Class Sitemap
 * @package App\Models
 */
class TagManager
{

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
