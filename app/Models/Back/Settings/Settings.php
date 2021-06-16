<?php

namespace App\Models\Back\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Settings extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param string $code
     * @param string $key
     *
     * @return false|Collection
     */
    public static function get(string $code, string $key)
    {
        $styles = Settings::where('code', $code)->where('key', $key)->first();

        if ($styles) {
            if ($styles->json) {
                return collect(json_decode($styles->value));
            }

            return $styles->value;
        }

        return false;
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function getProduct(string $key)
    {
        $styles = Settings::where('code', 'product')->where('key', $key)->first();

        if ($styles) {
            if ($styles->json) {
                return collect(json_decode($styles->value));
            }

            return $styles->value;
        }

        return false;
    }


    /**
     * @param string $key
     * @param mixed  $value
     * @param bool   $json
     *
     * @return mixed
     */
    public static function setProduct(string $key, $value, bool $json = true)
    {
        $styles = Settings::where('code', 'product')->where('key', $key)->first();

        if ($styles) {
            if ($json) {
                $values = collect(json_decode($styles->value));

                if ( ! $values->contains($value)) {
                    $values->push($value);
                }

                $value = json_encode($values);
            }

            return self::edit($styles->id, 'product', $key, $value, $json);
        }

        if ($json) {
            $values = [$value];

            $value = json_encode($values);
        }

        return self::insert('product', $key, $value, $json);
    }


    /**
     * @param string $code
     * @param string $key
     * @param        $value
     * @param bool   $json
     *
     * @return mixed
     */
    public static function insert(string $code, string $key, $value, bool $json)
    {
        return self::insertGetId([
            'code'       => $code,
            'key'        => $key,
            'value'      => $value,
            'json'       => $json,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }


    /**
     * @param int    $id
     * @param string $code
     * @param string $key
     * @param        $value
     * @param bool   $json
     *
     * @return bool
     */
    private static function edit(int $id, string $code, string $key, $value, bool $json)
    {
        return self::where('id', $id)->update([
            'code'       => $code,
            'key'        => $key,
            'value'      => $value,
            'json'       => $json,
            'updated_at' => Carbon::now()
        ]);
    }
}
