<?php

namespace App\Models\Front\Apartment;

use Illuminate\Database\Eloquent\Model;
use Bouncer;

class ApartmentDetail extends Model
{

    /**
     * @var string
     */
    protected $table = 'apartment_details';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title'];

    /**
     * @var string
     */
    protected $locale = 'en';


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
     * @param null  $lang
     * @param false $all
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null, bool $all = false)
    {
        if ($lang) {
            return $this->hasOne(ApartmentDetailTranslation::class, 'apartment_detail_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(ApartmentDetailTranslation::class, 'apartment_detail_id');
        }

        return $this->hasOne(ApartmentDetailTranslation::class, 'apartment_detail_id')->where('lang', $this->locale)->first();
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }


}
