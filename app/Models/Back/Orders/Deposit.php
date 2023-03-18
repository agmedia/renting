<?php

namespace App\Models\Back\Orders;

use App\Helpers\Helper;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * @var Request
     */
    protected $request;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }


    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return Helper::resolveOrderStatus($this->status_id);
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'payment_type'   => 'required',
            'payment_amount' => 'required'
        ]);

        if ( ! $request->input('order_id')) {
            $request->merge(['order_id' => config('settings.default_deposit_order_id')]);
        }

        $this->request = $request;

        return $this;
    }


    /**
     * @return mixed
     */
    public function create()
    {
        $method = in_array($this->request->payment_type, ['bank', 'cod']) ? $this->request->payment_type : 'card';

        return $this->insertGetId([
            'order_id'       => $this->request->order_id,
            'amount'         => $this->request->payment_amount,
            'signature'      => Helper::encryptor(now()->toISOString()),
            'payment_method' => $method,
            'payment_code'   => $this->request->payment_type,
            'paid'           => 0,
            'scope_id'       => $this->request->scope_id,
            'expire'         => 0,
            'status_id'      => config('settings.order.status.new'),
            'invoice'        => '',
            'comment'        => $this->request->comment,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now()
        ]);
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = $this->newQuery();

        if ($request->has('status')) {
            $query->where('status_id', '=', $request->input('status'));
        }

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search') . '%');
            });

            $query->orWhereHas('order', function ($subquery) use ($request) {
                $subquery->where('id', 'like', '%' . $request->input('search') . '%')
                         ->orWhere('payment_fname', 'like', '%' . $request->input('search'))
                         ->orWhere('payment_lname', 'like', '%' . $request->input('search'))
                         ->orWhere('payment_email', 'like', '%' . $request->input('search'));
            });
        }

        return $query->orderBy('created_at', 'desc');
    }
}
