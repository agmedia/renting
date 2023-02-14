<?php

namespace App\Models\Front\Apartment;

use App\Models\Back\Settings\Settings;
use Illuminate\Database\Eloquent\Model;
use Bouncer;
use Illuminate\Support\Collection;

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

        return $this->hasOne(ApartmentDetailTranslation::class, 'apartment_detail_id')->where('lang', $this->locale)/*->first()*/;
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation->title;
    }


    /**
     * @param int  $id
     * @param bool $group_result
     *
     * @return array
     */
    public static function getAmenitiesByApartment(int $id, bool $group_result = true): array
    {
        $locale = current_locale();
        $response = [];

        $amenities_by_groups = Settings::get('amenity', 'list')->sortBy('group')->groupBy('group');
        $existing = self::where('apartment_id', $id)->where('amenity', 1)->get();

        foreach ($amenities_by_groups as $group => $amenities) {
            foreach ($amenities as $amenity) {
                $has = $existing->where('group', $amenity->id)->first();

                if ($has) {
                    $response[$amenity->id] = [
                        'id' => $amenity->id,
                        'icon' => $amenity->icon,
                        'featured' => $amenity->featured,
                        'group' => $amenity->group_title->{$locale},
                        'title' => $amenity->title->{$locale},
                        'status' => 1
                    ];
                }
            }
        }

        if ($group_result) {
            return collect($response)->groupBy('group')->toArray();
        }

        return collect($response)->toArray();
    }


    /**
     * @param int $id
     *
     * @return array
     */
    public static function getDetailsByApartment(int $id): Collection
    {
        $response = [];
        $existing = self::where('apartment_id', $id)->where('amenity', 0)->get();

        foreach ($existing as $detail) {
            $response[$detail->id] = [
                'value'        => $detail->value,
                'group'        => $detail->group,
                'icon'         => $detail->icon,
                'gallery_id'   => $detail->gallery_id,
                'amenity'      => 0,
                'favorite'     => $detail->favorite,
                'status'       => 1
            ];

            foreach (ag_lang() as $lang) {
                $response[$detail->id]['title'][$lang->code] = $detail->translation($lang->code)->title;
                $response[$detail->id]['description'][$lang->code] = $detail->translation($lang->code)->subtitle;
            }
        }

        return collect($response);
    }


}
