<?php

namespace App\Models\Back\Orders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{

    /**
     * @var string
     */
    protected $table = 'order_history';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
