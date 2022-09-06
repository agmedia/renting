<?php

namespace App\Models\Front\Apartment;

use Illuminate\Database\Eloquent\Model;

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


}
