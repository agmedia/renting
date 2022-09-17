<?php

namespace App\Models\Back\Settings\Options;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OptionTranslation extends Model
{

    /**
     * @var string
     */
    protected $table = 'option_translations';

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
                'option_id'   => $id,
                'lang'        => $lang->code,
                'title'       => $request->title[$lang->code],
                'description' => $request->description[$lang->code],
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
            $saved = self::where('option_id', $id)->where('lang', $lang->code)->update([
                'lang'        => $lang->code,
                'title'       => $request->title[$lang->code],
                'description' => $request->description[$lang->code],
                'updated_at'  => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }
}
