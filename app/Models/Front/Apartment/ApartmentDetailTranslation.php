<?php

namespace App\Models\Front\Apartment;

use Illuminate\Database\Eloquent\Model;
use Bouncer;

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


}
