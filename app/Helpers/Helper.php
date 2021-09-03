<?php


namespace App\Helpers;

use App\Models\Back\Widget\WidgetGroup;
use App\Models\Front\Blog;
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
                               ->pluck('id');

            $authors = Author::where('title', 'like', '%' . $target . '%')->with('products')->get();
            //$publishers = Publisher::where('title', 'like', '%' . $target . '%')->get();

            foreach ($authors as $author) {
                $products = $products->merge($author->products()->pluck('id'));
            }

            $response->put('products', $products->unique());
            //$response->put('authors', $authors->products()->pluck('id'));
            //$response->put('publishers', $publishers);

            /*$data = view('front.layouts.partials.search_result', ['data' => $response])->render();

            $response->put('view', $data);*/

            if ($builder) {
                return $response;
            }

            return $response->toArray();
        }

        return false;
    }


    /**
     * @param string $description
     *
     * @return false|string
     */
    public static function setDescription(string $description)
    {
        $iterator = substr_count($description, '++');
        $offset = 0;
        $ids = [];

        for ($i = 0; $i < $iterator / 2; $i++) {
            $from = strpos($description, '++', $offset) + 2;
            $to = strpos($description, '++', $from + 2);
            $ids[] = substr($description, $from, $to - $from);

            $offset = $to + 2;
        }

        foreach ($ids as $id) {
            $wg = WidgetGroup::where('id', $id)->orWhere('slug', $id)->where('status', 1)->with('widgets')->first();

            $widgets = [];

            if ($wg->template == 'product_carousel' || $wg->template == 'page_carousel') {
                $widget = $wg->widgets()->first();
                $data = unserialize($widget->data);

                if (static::isDescriptionTarget($data, 'product')) {
                    if (isset($data['new']) && $data['new'] == 'on') {
                        $items = Product::last()->get();
                    }

                    if (isset($data['popular']) && $data['popular'] == 'on') {
                        $items = Product::popular()->get();
                    }

                    if (isset($data['list']) && $data['list']) {
                        $items = Product::whereIn('id', $data['list'])->active()->get();
                    }
                }

                if (static::isDescriptionTarget($data, 'blog')) {
                    if (isset($data['new']) && $data['new'] == 'on') {
                        $items = Blog::last()->active()->get();
                    }

                    if (isset($data['popular']) && $data['popular'] == 'on') {
                        $items = Blog::popular()->active()->get();
                    }

                    if (isset($data['list']) && $data['list']) {
                        $items = Blog::whereIn('id', $data['list'])->active()->get();
                    }
                }

                $widgets = [
                    'title' => $widget->title,
                    'subtitle' => $widget->subtitle,
                    'url' => null,
                    'css' => $data['css'],
                    'container' => (isset($data['container']) && $data['container'] == 'on') ? 1 : null,
                    'background' => (isset($data['background']) && $data['background'] == 'on') ? 1 : null,
                    'items' => $items
                ];

            } else {
                foreach ($wg->widgets()->orderBy('sort_order')->get() as $widget) {
                    $data = unserialize($widget->data);

                    $widgets[] = [
                        'title' => $widget->title,
                        'subtitle' => $widget->subtitle,
                        'url' => $widget->url,
                        'image' => $widget->image,
                        'width' => $widget->width,
                        'right' => (isset($data['right']) && $data['right'] == 'on') ? 1 : null,
                    ];
                }
            }

            $description = str_replace(
                '++' . $id . '++',
                view('front.layouts.widget.widget_' . $wg->template, ['data' => $widgets]),
                $description
            );
        }

        return substr($description, 3, -4);
    }


    /**
     * @param array  $data
     * @param string $target
     *
     * @return bool
     */
    public static function isDescriptionTarget(array $data, string $target): bool
    {
        if (isset($data['target']) && $data['target'] == $target) { return true; }
        if (isset($data['group']) && $data['group'] == $target) { return true; }

        return false;
    }

}
