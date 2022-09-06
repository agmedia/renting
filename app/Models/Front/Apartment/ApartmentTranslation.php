<?php

namespace App\Models\Front\Apartment;

use Illuminate\Database\Eloquent\Model;
use Bouncer;

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


}
