<?php

namespace App\Models\Front\Apartment;

use App\Models\Back\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Carbon;

class Apartment extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'apartments';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'description', 'image', 'thumb', 'cijena', 'for', 'url'];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var Request
     */
    protected $request;


    /**
     * Gallery constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
    }


    /**
     * @param bool $all
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ApartmentImage::class, 'apartment_id')->orderBy('sort_order');
    }


    /**
     * @param bool $all
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(ApartmentDetail::class, 'apartment_id')->where('amenity', 0);
    }


    /**
     * @param bool $all
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function amenities()
    {
        return $this->hasMany(ApartmentDetail::class, 'apartment_id')->where('amenity', 1);
    }


    /**
     * @param null  $lang
     * @param false $all
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null, bool $all = false)
    {
        if ($lang) {
            return $this->hasOne(ApartmentTranslation::class, 'apartment_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(ApartmentTranslation::class, 'apartment_id');
        }

        return $this->hasOne(ApartmentTranslation::class, 'apartment_id')->where('lang', $this->locale)/*->first()*/;
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation()->first()->title;
    }


    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->translation()->first()->description;
    }


    /**
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->images()->where('published', 1)->where('default', 1)->first()->image;
    }


    /**
     * @return string
     */
    public function getThumbAttribute()
    {
        return 'test-thumb';
    }


    public function getCijenaAttribute()
    {
        $main = ag_currencies()->where('main', true)->first();

        if ( ! $main) {
            $main = ag_currencies()->first();
        }

        return ($main->symbol_left ? $main->symbol_left . ' ' : '') . number_format(($this->price * $main->value), $main->decimal_places, ',', '.') . ($main->symbol_right ? ' ' . $main->symbol_right : '');
    }


    /**
     * @return string
     */
    public function getForAttribute()
    {
        return collect(config('settings.apartment_targets'))->where('id', $this->target)->first()['title'][current_locale()];
    }


    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return '#';
    }


    public function dates()
    {
        $response = [];
        $orders = Order::where('apartment_id', $this->id)->where('date_to', '>', now())->get();

        foreach ($orders as $order) {
            $response[] = [Carbon::make($order->date_from)->format('Y-m-d'), Carbon::make($order->date_to)->format('Y-m-d')];
        }

        return $response;
    }

}
