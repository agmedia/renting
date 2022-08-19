<?php

namespace App\Models\Back\Apartment;

use App\Helpers\ProductHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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


    /**
     * @param int     $id
     * @param Request $request
     *
     * @return bool
     */
    public static function createDetails(int $id, Request $request): bool
    {
        if ( ! $request->added_details) {
            return false;
        }

        $details_to_add = collect(json_decode($request->added_details));

        foreach ($details_to_add as $detail) {
            $saved = self::insertGetId([
                'apartment_id' => $id,
                'value'        => $detail->value,
                'group'        => $detail->group,
                'icon'         => $detail->icon,
                'gallery_id'   => $detail->gallery_id,
                'amenity'      => 0,
                'favorite'     => $detail->favorite,
                'status'       => 1,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);

            ApartmentDetailTranslation::create($saved, $detail);


            if ( ! $saved) {
                return false;
            }
        }


        return true;
    }


    /**
     * @param int     $id
     * @param Request $request
     *
     * @return bool
     */
    public static function editDetails(int $id, Request $request): bool
    {
        self::where('apartment_id', $id)->where('amenity', 0)->delete();

        return self::createDetails($id, $request);
    }


    /**
     * @param int     $id
     * @param Request $request
     *
     * @return bool
     */
    public static function createAmenities(int $id, Request $request): bool
    {
        if ( ! $request->amenity) {
            return false;
        }

        $list = collect(config('settings.apartment_details'));

        foreach ($request->amenity as $amenity_id => $null) {
            $amenity = $list->where('id', $amenity_id)->first();

            $saved = self::insertGetId([
                'apartment_id' => $id,
                'value'        => 0,
                'group'        => $amenity_id,
                'icon'         => $amenity['icon'],
                'gallery_id'   => 0,
                'amenity'      => 1,
                'favorite'     => $amenity['featured'],
                'status'       => 1,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);

            ApartmentDetailTranslation::createAmenity($saved, $amenity);
        }

        if ( ! $saved) {
            return false;
        }

        return true;
    }


    /**
     * @param int     $id
     * @param Request $request
     *
     * @return bool
     */
    public static function editAmenities(int $id, Request $request): bool
    {
        self::where('apartment_id', $id)->where('amenity', 1)->delete();

        return self::createAmenities($id, $request);
    }


    /**
     * @param int $id
     *
     * @return array
     */
    public static function getAmenitiesByApartment(int $id): array
    {
        $locale = current_locale();
        $response = [];

        $amenities_by_groups = collect(config('settings.apartment_details'))->groupBy('group');
        $existing = self::where('apartment_id', $id)->where('amenity', 1)->get();

        foreach ($amenities_by_groups as $group => $amenities) {
            foreach ($amenities as $amenity) {
                $response[$amenity['id']] = [
                    'id' => $amenity['id'],
                    'icon' => $amenity['icon'],
                    'group' => $amenity['group_title'][$locale],
                    'title' => $amenity['title'][$locale],
                    'status' => 0
                ];

                $has = $existing->where('group', $amenity['id'])->first();

                if ($has) {
                    $response[$amenity['id']]['status'] = 1;
                }
            }
        }

        return collect($response)->groupBy('group')->toArray();
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


    /**
     * @param int $id
     *
     * @return array
     */
    public static function getFavorites(): Collection
    {
        $response = [];
        $favorites = self::where('amenity', 0)->where('favorite', 1)->get();

        foreach ($favorites as $detail) {
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
