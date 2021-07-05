<?php

namespace App\Models\Front\Catalog;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
