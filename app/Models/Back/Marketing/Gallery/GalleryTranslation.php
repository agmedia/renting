<?php

namespace App\Models\Back\Marketing\Gallery;

use App\Helpers\ProductHelper;
use App\Models\Back\Catalog\Product\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class GalleryTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'gallery_translations';

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
    public static function create(int $id, Request $request): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::insertGetId([
                'gallery_id'  => $id,
                'lang'        => $lang->code,
                'title'       => $request->title[$lang->code],
                'description' => '',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
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
    public static function edit(int $id, Request $request): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::where('gallery_id', $id)->where('lang', $lang->code)->update([
                'title'       => $request->title[$lang->code],
                'description' => '',
                'updated_at'  => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }

}
