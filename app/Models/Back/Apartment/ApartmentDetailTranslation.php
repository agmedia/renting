<?php

namespace App\Models\Back\Apartment;

use App\Helpers\ProductHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Validation\ValidationException;

class ApartmentDetailTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'apartment_details_translations';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param int $id
     * @param     $detail
     *
     * @return bool
     */
    public static function create(int $id, $detail): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::insertGetId([
                'apartment_detail_id' => $id,
                'lang'                => $lang->code,
                'title'               => $detail->title->{$lang->code},
                'subtitle'            => isset($detail->description->{$lang->code}) ? $detail->description->{$lang->code} : '',
                'group_title'         => $detail->group,
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()
            ]);

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
    public static function createAmenity(int $id, $amenity): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::insertGetId([
                'apartment_detail_id' => $id,
                'lang'                => $lang->code,
                'title'               => $amenity['title'][$lang->code],
                'subtitle'            => isset($amenity['description'][$lang->code]) ? $amenity['description'][$lang->code] : '',
                'group_title'         => $amenity['group_title'][$lang->code],
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }

}
