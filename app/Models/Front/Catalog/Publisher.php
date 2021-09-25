<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
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
     * @param int $id
     *
     * @return Collection
     */
    public function categories(int $id = 0): Collection
    {
        return Cache::remember('publisher.category.' . $id, config('cache.life'), function () use ($id) {
            if ( ! $id) {
                $query = Category::query()->select('id', 'title', 'slug')->whereHas('products', function ($query) {
                    $query->where('publisher_id', $this->id);
                });

            } else {
                $query = Category::query()->whereHas('products', function ($query) {
                    $query->where('publisher_id', $this->id);
                })->where('parent_id', $id);
            }

            return $query->with('parent')
                         ->withCount(['products as products_count' => function ($query) {
                             $query->where('publisher_id', $this->id);
                         }])
                         ->orderBy('title')
                         ->get();
        });
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
