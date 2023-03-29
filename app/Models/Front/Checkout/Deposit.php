<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Currency;
use App\Helpers\Helper;
use App\Mail\Order\SendToAdmin;
use App\Mail\Order\SendToCustomer;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Orders\Transaction;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    protected $status;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected $main_currency;


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->main_currency = Currency::session();
    }


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
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @param string $status
     * @param int    $deposit_id
     *
     * @return $this
     */
    public function setStatus(string $status, int $deposit_id = 0)
    {
        if ($deposit_id) {
            $this->newQuery()->where('id', $deposit_id)->update([
                'status_id' => config('settings.order.status.' . $status)
            ]);
        }

        $this->update([
            'status_id' => config('settings.order.status.' . $status)
        ]);

        return $this;
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function finishTransaction(Request $request)
    {
        $this->setRequest($request);

        $this->status = ($this->request->has('approval_code') && $this->request->input('approval_code') != null)
            ? config('settings.order.status.paid')
            : config('settings.order.status.declined');

        $this->update(['status_id' => $this->status]);

        if ($this->status == config('settings.order.status.paid')) {
            Transaction::insert([
                'order_id'        => $this->order_id,
                'success'         => 1,
                'amount'          => $this->amount,
                'signature'       => $this->request->input('signature'),
                'payment_type'    => $this->payment_method,
                'payment_plan'    => '',
                'payment_partner' => $this->payment_code,
                'datetime'        => now(),
                'approval_code'   => $this->request->input('approval_code'),
                'pg_order_id'     => $this->request->input('order_number'),
                'lang'            => $this->main_currency->code,
                'stan'            => '',
                'error'           => '',
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now()
            ]);
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function sendEmails()
    {
        if ($this->status == config('settings.order.status.paid')) {
            $order = Order::query()->where('id', $this->order_id)->first();

            if ($order) {
                $checkout               = [];
                $checkout['is_deposit'] = true;
                $checkout['deposit']    = $this->toArray();

                Mail::to(Helper::getBasicInfo()->email)->send(new SendToAdmin($order, $checkout));
                Mail::to($this->payment_email)->send(new SendToCustomer($order, $checkout));
            }

        }

        return $this;
    }

}
