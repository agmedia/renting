<?php

namespace App\Models\Back\Orders;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Deposit extends Model
{

    /**
     * @var string
     */
    protected $table = 'order_deposit';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @param Order   $order
     * @param Request $request
     *
     * @return mixed
     */
    public static function create(Order $order, Request $request)
    {
        $method = $request->payment_type;
        if ( ! in_array($request->payment_type, ['bank', 'cod'])) {
            $method = 'card';
        }

        return self::insertGetId([
            'order_id'       => $order->id,
            'amount'         => $request->payment_amount,
            'signature'      => Helper::encryptor(now()->toISOString()),
            'payment_method' => $method,
            'payment_code'   => $request->payment_type,
            'paid'           => 0,
            'expire'         => 0,
            'status_id'      => config('settings.order.status.new'),
            'invoice'        => '',
            'comment'        => $request->comment,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now()
        ]);
    }
}
