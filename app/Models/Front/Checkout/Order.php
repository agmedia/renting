<?php

namespace App\Models\Front\Checkout;

use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = ['order_status_id'];

    /**
     * @var string[]
     */
    protected $appends = ['total_amount', 'total_text'];

    /**
     * @var array
     */
    public $order = [];

    /**
     * @var int
     */
    public $order_id;

    /**
     * @var Checkout|null
     */
    public $checkout = null;


    /**
     * Order constructor.
     *
     * @param int $order_id
     */
    public function __construct(array $data = null)
    {
        $this->order = $data;
    }


    /**
     * @param int $id
     *
     * @return mixed
     */
    public function status(int $id)
    {
        $statuses = Settings::get('order', 'statuses');

        return $statuses->where('id', $id)->first();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function apartment()
    {
        return $this->hasOne(Apartment::class, 'apartment_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(OrderTotal::class, 'order_id')->orderBy('sort_order');
    }


    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return $this->status($this->order_status_id);
    }


    /**
     * @return string
     */
    public function getTotalAmountAttribute()
    {
        return number_format(($this->total * $this->main_currency->value), $this->main_currency->decimal_places, ',', '.');
    }


    /**
     * @return string
     */
    public function getTotalTextAttribute(): string
    {
        $left = $this->main_currency->symbol_left ? $this->main_currency->symbol_left . ' ' : '';
        $right = $this->main_currency->symbol_right ? ' ' . $this->main_currency->symbol_right : '';

        return $left . number_format(($this->total * $this->main_currency->value), $this->main_currency->decimal_places, ',', '.') . $right;
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeUnfinished(Builder $query): Builder
    {
        return $query->where('order_status_id', config('settings.order.status.unfinished'));
    }


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id)
    {
        $this->order_id = $id;

        return $this;
    }


    /**
     * @param Checkout $checkout
     *
     * @return $this
     */
    public function resolveMissing(Checkout $checkout)
    {
        $this->checkout                 = $checkout;
        $this->order['order_status_id'] = config('settings.order.status.unfinished');

        $this->order_id = $this->insertForm();

        if ($this->order_id) {
            OrderHistory::store($this->order_id);

            foreach ($this->checkout->total['total'] as $key => $total) {
                OrderTotal::where('order_id', $this->order_id)->delete();
                OrderTotal::insertRow($this->order_id, $total['code'], $total['total'], $key);
            }
        }

        return $this;
    }


    /**
     * @return mixed|null
     */
    public function resolvePaymentForm()
    {
        if ($this->checkout) {
            $method = new PaymentMethod($this->checkout->payment->code);

            return $method->resolveForm($this);
        }

        return null;
    }


    /**
     * @param string $status
     *                      [ 'new', 'unfinished', 'declined', 'paid', 'send']
     * @param int    $order_id
     *
     * @return bool
     */
    public function updateStatus(string $status, int $order_id = 0)
    {
        if ($order_id) {
        }

        return $this->update(['order_status_id' => config('settings.order.status.' . $status)]);
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return mixed
     */
    private function insertForm()
    {
        if ($this->order_id) {
            \App\Models\Back\Orders\Order::where('id', $this->order_id)->update(
                $this->modelArray(true)
            );

            return $this->order_id;
        }

        return \App\Models\Back\Orders\Order::insertGetId(
            $this->modelArray()
        );
    }


    /**
     * @param bool $update
     *
     * @return array
     */
    private function modelArray(bool $update = false): array
    {
        $user_id = auth()->user() ? auth()->user()->id : 0;
        $total   = collect($this->checkout->total['total'])->where('code', 'total')->first()['total'];

        $response = [
            'apartment_id'        => $this->checkout->apartment->id,
            'user_id'             => $user_id,
            'affiliate_id'        => 0,
            'order_status_id'     => $this->order['order_status_id'],
            'invoice'             => '',
            'total'               => $total,
            'date_from'           => Carbon::make($this->checkout->from),
            'date_to'             => Carbon::make($this->checkout->to),
            'payment_fname'       => $this->checkout->firstname,
            'payment_lname'       => $this->checkout->lastname,
            'payment_address'     => '',
            'payment_zip'         => '',
            'payment_city'        => '',
            'payment_phone'       => $this->checkout->phone,
            'payment_email'       => $this->checkout->email,
            'payment_method'      => $this->checkout->payment->code,
            'payment_code'        => $this->checkout->payment->code,
            'payment_card'        => '',
            'payment_installment' => '',
            'company'             => '',
            'oib'                 => '',
            'options'             => serialize($this->checkout->added_options),
            'comment'             => '',
            'approved'            => '',
            'approved_user_id'    => '',
            'updated_at'          => Carbon::now()
        ];

        if ( ! $update) {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }

}
