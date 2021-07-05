<?php

namespace App\Models\Front\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Bouncer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends Model
{

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function action()
    {
        return $this->hasOne(ProductAction::class, 'id', 'action_id')->active();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, CategoryProducts::class, 'product_id', 'id', 'id', 'category_id');
    }


    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOneThrough|\Illuminate\Database\Query\Builder|mixed|object|null
     */
    public function category()
    {
        return $this->hasOneThrough(Category::class, CategoryProducts::class, 'product_id', 'id', 'id', 'category_id')
            ->where('parent_id', 0)
            ->first();
    }


    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOneThrough|\Illuminate\Database\Query\Builder|mixed|object|null
     */
    public function subcategory()
    {
        return $this->hasOneThrough(Category::class, CategoryProducts::class, 'product_id', 'id', 'id', 'category_id')
            ->where('parent_id', '!=', 0)
            ->first();
    }


    /**
     * @param Category|null $category
     * @param Category|null $subcategory
     *
     * @return string
     */
    public function url(Category $category = null, Category $subcategory = null)
    {
        if ( ! $category) {
            $category = $this->category();
        }

        if ( ! $subcategory) {
            $subcategory = $this->subcategory();
        }

        if ($subcategory) {
            return route('catalog.route', [
                'group' => Str::slug($category->group),
                'cat' => $category,
                'subcat' => $subcategory,
                'prod' => $this
            ]);
        }

        return route('catalog.route', [
            'group' => Str::slug($category->group),
            'cat' => $category,
            'subcat' => $this
        ]);
    }


    /**
     * @return string
     */
    public function priceString()
    {
        $price = explode('.', $this->price);

        return number_format($this->price, 0, '', '.') . ',<small>' . substr($price[1], 0, 2) . 'kn</small>';
    }


    /**
     * @param Category|null $category
     * @param Category|null $subcategory
     *
     * @return string
     */
    public function categoriesString(Category $category = null, Category $subcategory = null)
    {
        if ( ! $category) {
            $category = $this->category();
        }

        if ( ! $subcategory) {
            $subcategory = $this->subcategory();
        }

        $catstring = '<span class="fs-xs ms-1"><a href="' . route('catalog.route', ['group' => Str::slug($category->group), 'cat' => $category]) . '">' . $category->title . '</a>, ';

        if ($subcategory) {
            $substring = '</span><span class="fs-xs ms-1"><a href="' . route('catalog.route', ['group' => Str::slug($category->group), 'cat' => $category, 'subcat' => $subcategory]) . '">' . $subcategory->title . '</a></span>';

            return $catstring . $substring;
        }

        return $catstring;
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeOnAction($query)
    {
        $actions = ProductAction::active()->pluck('product_id');

        if ($actions->count() < 8) {
            $count = 8 - $actions->count();

            for ($i = 0; $i < $count; $i++) {
                $product = Product::whereNotIn('id', $actions)->inRandomOrder()->limit(1)->pluck('id');
                $actions->push($product[0]);
            }
        }

        return $query->whereIn('id', $actions)->with('action');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast($query, $count = 9)
    {
        return $query->where('status', 1)->orderBy('updated_at', 'desc')->limit($count);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePopular($query, $count = 9)
    {
        return $query->where('status', 1)->orderBy('viewed', 'desc')->limit($count);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeTopponuda($query, $count = 9)
    {
        return $query->where('status', 1)->where('topponuda', 1)->orderBy('updated_at', 'desc')->limit($count);
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/
    // Static functions

    /**
     * @return mixed
     */
    public static function getMenu()
    {
        return self::where('status', 1)->select('id', 'name')->get();
    }


    /**
     * Return the list usually for
     * select or autocomplete html element.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function list()
    {
        $query = (new self())->newQuery();

        return $query->where('status', 1)->select('id', 'name')->get();
    }


    /**
     * @param $id
     *
     * @return string
     */
    public static function resolveLink($id)
    {
        $product = self::find($id);

        return route('proizvod', [
            'cat' => isset($product->category()->slug) ? $product->category()->slug : '',
            'subcat' => $product->subcategory() ? $product->subcategory()->slug : 'ikoi',
            'prod' => $product->slug
        ]);
    }

}
