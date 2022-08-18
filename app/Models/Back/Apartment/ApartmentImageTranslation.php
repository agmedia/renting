<?php

namespace App\Models\Back\Apartment;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApartmentImageTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'apartment_images_translations';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param int   $id
     * @param array $title
     *
     * @return bool
     */
    public static function create(int $id, array $title): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::insertGetId([
                'apartment_image_id' => $id,
                'lang'               => $lang->code,
                'title'              => $title[$lang->code],
                'alt'                => $title[$lang->code],
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }


    /**
     * @param int   $id
     * @param array $title
     *
     * @return bool
     */
    public static function edit(int $id, array $image): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::where('apartment_image_id', $id)->where('lang', $lang->code)->update([
                'title'      => $image['title'][$lang->code],
                'alt'        => $image['alt'][$lang->code],
                'updated_at' => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }

}
