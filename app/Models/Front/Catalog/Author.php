<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        return $this->hasMany(Product::class, 'author_id', 'id')->active()->hasStock();
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
        return Cache::remember('author.category.' . $id, config('cache.life'), function () use ($id) {
            if ( ! $id) {
                $query = Category::query()->select('id', 'title', 'slug')->whereHas('products', function ($query) {
                    $query->where('author_id', $this->id);
                });

            } else {
                $query = Category::query()->whereHas('products', function ($query) {
                    $query->where('author_id', $this->id);
                })->where('parent_id', $id);
            }

            return $query->with('parent')
                         ->withCount(['products as products_count' => function ($query) {
                             $query->where('author_id', $this->id);
                         }])
                         ->orderBy('title')
                         ->get();
        });
    }


    /**
     * @return Collection
     */
    public static function letters(): Collection
    {
        $letters = collect();
        $authors = Author::active()->pluck('letter')->unique();

        foreach (Helper::abc() as $item) {
            if ($item == $authors->contains($item)) {
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
