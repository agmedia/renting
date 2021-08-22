<?php


namespace App\Helpers;


use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Helper
{

    /**
     * @param float $price
     * @param int   $discount
     *
     * @return float|int
     */
    public static function calculateDiscountPrice(float $price, int $discount)
    {
        return $price - ($price * ($discount / 100));
    }


    /**
     * @param $list_price
     * @param $seling_price
     *
     * @return float|int
     */
    public static function calculateDiscount($list_price, $seling_price)
    {
        return (($list_price - $seling_price) / $list_price) * 100;;
    }


    /**
     * @return string[]
     */
    public static function abc()
    {
        return ['A', 'B', 'C', 'Ć', 'Č', 'D', 'Đ', 'DŽ', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'LJ', 'M', 'N', 'NJ', 'O', 'P', 'R', 'S', 'Š', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ž'];
    }


    /**
     * @param string $price
     *
     * @return string
     */
    public static function priceString($price): string
    {
        if (is_float($price)) {
            $price = '"' . number_format($price, 2) . '"';
        }

        if ( ! is_string($price)) {
            return 'Not a number.!';
        }

        $set = explode('.', $price);

        if ( ! isset($set[1])) {
            $set[1] = '00';
        }

        return number_format($price, 0, '', '.') . ',<small>' . substr($set[1], 0, 2) . 'kn</small>';
    }


    /**
     * @param string $target
     * @param bool   $builder
     *
     * @return array|false|Collection
     */
    public static function search(string $target = '', bool $builder = false)
    {
        if ($target != '') {
            $response = collect();

            $products = Product::where('name', 'like', '%' . $target . '%')
                               ->orWhere('meta_description', 'like', '%' . $target . '%')
                               ->get();

            $authors = Author::where('title', 'like', '%' . $target . '%')->get();
            $publishers = Publisher::where('title', 'like', '%' . $target . '%')->get();

            $response->put('products', $products);
            $response->put('authors', $authors);
            $response->put('publishers', $publishers);

            $data = view('front.layouts.partials.search_result', ['data' => $response])->render();

            $response->put('view', $data);

            if ($builder) {
                return $response;
            }

            return $response->toArray();
        }

        return false;
    }

}
