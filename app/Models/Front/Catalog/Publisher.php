<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use App\Helpers\ProductHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
        return $this->hasMany(Product::class, 'publisher_id', 'id')->active()->hasStock();
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
     * @param $query
     *
     * @return mixed
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeBasicData($query)
    {
        return $query->select('id', 'title', 'slug', 'url');
    }


    /**
     * @param array $request
     * @param int   $limit
     *
     * @return Builder
     */
    public function filter(array $request, int $limit = 20): Builder
    {
        $query = (new Publisher())->newQuery();

        $query->active();

        if ($request['search_publisher']) {
            $query = Helper::searchByTitle($query, $request['search_publisher']);
        }

        if ($request['group']) {
            $query->whereHas('products', function ($query) use ($request) {
                $query = ProductHelper::queryCategories($query, $request);

                if ($request['author']) {
                    if (strpos($request['author'], '+') !== false) {
                        $arr = explode('+', $request['author']);
                        $pubs = Author::query()->whereIn('slug', $arr)->pluck('id');

                        $query->whereIn('author_id', $pubs);
                    } else {
                        $query->where('author_id', $request['author']);
                    }
                }
            });

            if ($query->count() > 80) {
                $query->featured();
            }
        }

        if ($request['author'] && ! $request['group']) {
            $query->whereHas('products', function ($query) use ($request) {
                $query->where('author_id', $request['author']);
            });

            if ($query->count() > 80) {
                $query->featured();
            }
        }

        return $query->limit($limit)->orderBy('title');
    }


    /**
     * @return Collection
     */
    public static function letters(): Collection
    {
        $letters = collect();
        $publishers = Publisher::active()->pluck('letter')->unique();

        foreach (Helper::abc() as $item) {
            if ($item == $publishers->contains($item)) {
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
