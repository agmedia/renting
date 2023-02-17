<?php

namespace App\Models\Front\Apartment;

use Illuminate\Database\Eloquent\Model;

class ApartmentImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'apartment_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'alt', 'webp', 'thumb'];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var Model
     */
    protected $resource;


    /**
     * apartment constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
    }


    /**
     * @param null $lang
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null)
    {
        if ($lang) {
            return $this->hasOne(ApartmentImageTranslation::class, 'apartment_image_id')->where('lang', $lang)->first();
        }

        return $this->hasOne(ApartmentImageTranslation::class, 'apartment_image_id')->where('lang', $this->locale)/*->first()*/;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(ApartmentImageTranslation::class, 'apartment_image_id');
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return (isset($this->translation->title) && $this->translation->title) ? $this->translation->title : '';
    }


    /**
     * @return string
     */
    public function getAltAttribute()
    {
        return (isset($this->translation->alt) && $this->translation->alt) ? $this->translation->alt : '';
    }


    /**
     * @return string
     */
    public function getWebpAttribute()
    {
        return str_replace('.jpg', '.webp', $this->image);
    }


    /**
     * @return string
     */
    public function getThumbAttribute()
    {
        return str_replace('.jpg', '-thumb.webp', $this->image);
    }

}
