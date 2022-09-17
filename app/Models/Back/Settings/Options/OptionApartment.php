<?php

namespace App\Models\Back\Settings\Options;

use App\Models\Back\Apartment\Apartment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OptionApartment extends Model
{

    /**
     * @var string
     */
    protected $table = 'option_to_apartment';


    /**
     * @param int   $option_id
     * @param array $apartments
     *
     * @return bool
     */
    public static function populate(int $option_id, array $apartments): bool
    {
        self::where('option_id', $option_id)->delete();

        foreach ($apartments as $apartment) {
            if ($apartment != 'all') {
                self::insert([
                    'option_id' => $option_id,
                    'apartment_id' => $apartment
                ]);

            } else {
                $ids = Apartment::pluck('id');

                foreach ($ids as $id) {
                    self::insert([
                        'option_id' => $option_id,
                        'apartment_id' => $id
                    ]);
                }
            }
        }

        return true;
    }
}
