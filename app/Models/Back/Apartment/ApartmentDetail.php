<?php

namespace App\Models\Back\Apartment;

use App\Helpers\ProductHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
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

}
