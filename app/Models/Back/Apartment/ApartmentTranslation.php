<?php

namespace App\Models\Back\Apartment;

use App\Helpers\ProductHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApartmentTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'apartment_translations';

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
                'apartment_id'     => $id,
                'lang'             => $lang->code,
                'title'            => $request->title[$lang->code],
                'description'      => $request->description[$lang->code],
                'meta_title'       => null,
                'meta_description' => null,
                'slug'             => Str::slug($request->title[$lang->code]),
                'url'              => '/' . Str::slug($request->title[$lang->code]),
                'tags'             => 'null',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
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
            $saved = self::where('apartment_id', $id)->where('lang', $lang->code)->update([
                'title'       => $request->title[$lang->code],
                'description'      => $request->description[$lang->code],
                'meta_title'       => null,
                'meta_description' => null,
                'slug'             => Str::slug($request->title[$lang->code]),
                'url'              => '/' . Str::slug($request->title[$lang->code]),
                'tags'             => 'null',
                'updated_at'  => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }


}
