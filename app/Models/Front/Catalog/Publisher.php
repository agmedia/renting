<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Publisher
 * @package App\Models\Front\Catalog
 */
class Publisher extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'publishers';

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
    public function products()
    {
        return $this->hasMany(Product::class, 'publisher_id', 'id');
    }


    /**
     * @param int $id
     *
     * @return Collection
     */
    public function categories(int $id = 0): Collection
    {
        $categories = collect();
        $products = $this->products()->active()->get();

        foreach ($products as $product) {
            $cats = $product->categories()->where('parent_id', $id)->first();

            if ($cats) {
                $categories->push($cats);
            }
        }

        return $categories->unique('id')->sortBy('id');
    }


    /**
     * @return string
     */
    public function url()
    {
        return route('catalog.route.publisher', [
            'publisher' => $this
        ]);
    }


    /**
     * @return Collection
     */
    public static function letters(): Collection
    {
        $letters = collect();
        $publisher = Publisher::all();

        $results = $publisher->sortBy('title')->groupBy(function ($item, $key) {
            return substr($item['title'], 0, 1);
        })->keys();

        foreach (Helper::abc() as $item) {
            if ($item == $results->contains($item)) {
                $letters->push([
                    'value' => $item,
                    'active' => true
                ]);
            } else {
                $letters->push([
                    'value' => $item,
                    'active' => false
                ]);
            }
        }

        return $letters;
    }

}
