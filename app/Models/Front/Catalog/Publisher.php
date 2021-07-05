<?php

namespace App\Models\Front\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Publisher extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'publishers';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
