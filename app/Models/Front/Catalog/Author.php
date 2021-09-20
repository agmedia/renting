<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Author
 * @package App\Models\Front\Catalog
 */
class Author extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'authors';

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
        return $this->hasMany(Product::class, 'author_id', 'id');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    /**
     * @param int $id
     *
     * @return Collection
     */
    public function categories(int $id = 0): Collection
    {
        $categories = collect();
        $products = $this->products()->get();

        foreach ($products as $product) {
            $cats = $product->categories()->where('parent_id', $id)->first();

            if ($cats) {
                $categories->push($cats);
            }
        }

        return $categories->unique('id')->sortBy('id');
    }


    /**
     * @return Collection
     */
    public static function letters(): Collection
    {
        $letters = collect();
        $authors = Author::all();

        $results = $authors->sortBy('title')->groupBy(function ($item, $key) {
            $letter = substr($item['title'], 0, 2);
            Log::info('Autor');
             Log::info($letter);

            if (strlen($letter) > 1 && ! in_array($letter, ['Ć','Č','Đ','Š','Ž'])) {
                $letter = substr($letter, 0, 1);
            }

            return $letter;
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
