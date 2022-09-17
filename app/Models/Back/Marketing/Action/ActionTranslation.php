<?php

namespace App\Models\Back\Marketing\Action;

use App\Helpers\Helper;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Product\ProductCategory;
use App\Models\Back\Marketing\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActionTranslation extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'apartment_actions_translations';

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
                'apartment_action_id' => $id,
                'lang'                => $lang->code,
                'title'               => $request->title[$lang->code],
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
    public static function edit(int $id, Request $request): bool
    {
        foreach (ag_lang() as $lang) {
            $saved = self::where('apartment_action_id', $id)->where('lang', $lang->code)->update([
                'lang'       => $lang->code,
                'title'      => $request->title[$lang->code],
                'updated_at' => Carbon::now()
            ]);

            if ( ! $saved) {
                return false;
            }
        }

        return true;
    }
}
