<?php

namespace App\Models\Front\Checkout;

use App\Helpers\Helper;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderProduct;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

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
     * @var null|array
     */
    protected $oc_data = null;


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
     * @return void
     */
    public function setId(int $id)
    {
        $this->order_id = $id;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return $this->status($this->order_status_id);
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
     * @param Checkout $checkout
     *
     * @return $this
     */
    public function resolveMissing(Checkout $checkout)
    {
        $this->checkout                 = $checkout;
        $this->order['order_status_id'] = config('settings.order.status.unfinished');

        $id = $this->insertForm();

        if ($id) {
            OrderHistory::store($id);

            foreach ($this->checkout->total['total'] as $key => $total) {
                OrderTotal::where('order_id', $id)->delete();
                OrderTotal::insertRow($id, $total['code'], $total['total'], $key);
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












    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setData(string $id)
    {

        $id   = str_replace('-' . date('Y'), '', $id);
        $data = \App\Models\Back\Orders\Order::where('id', $id)->first();

        if ($data) {
            $this->oc_data = $data;
        }

        return $this;
    }


    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->oc_data;
    }


    /**
     * @param array $data
     *
     * @return bool
     */
    public function createFrom(array $data = [])
    {
        if ( ! empty($data)) {
            $this->order = $data;
        }

        if ( ! empty($this->order) && isset($this->order['cart'])) {
            $user_id = auth()->user() ? auth()->user()->id : 0;

            $order_id = \App\Models\Back\Orders\Order::insertGetId([
                'user_id'             => $user_id,
                'affiliate_id'        => 0,
                'order_status_id'     => $this->order['order_status_id'],
                'invoice'             => '',
                'total'               => $this->order['cart']['total'],
                'payment_fname'       => $this->order['address']['fname'],
                'payment_lname'       => $this->order['address']['lname'],
                'payment_address'     => $this->order['address']['address'],
                'payment_zip'         => $this->order['address']['zip'],
                'payment_city'        => $this->order['address']['city'],
                'payment_state'       => $this->order['address']['state'],
                'payment_phone'       => $this->order['address']['phone'] ?: null,
                'payment_email'       => $this->order['address']['email'],
                'payment_method'      => $this->order['payment']->title,
                'payment_code'        => $this->order['payment']->code,
                'payment_card'        => '',
                'payment_installment' => '',
                'company'             => $this->order['address']['company'],
                'oib'                 => $this->order['address']['oib'],
                'comment'             => '',
                'approved'            => '',
                'approved_user_id'    => '',
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()
            ]);

            if ($order_id) {
                // HISTORY
                OrderHistory::insert([
                    'order_id'   => $order_id,
                    'user_id'    => $user_id,
                    'comment'    => config('settings.order.made_text'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $this->updateProducts($order_id);
                $this->updateTotal($order_id);

                $this->oc_data = \App\Models\Back\Orders\Order::where('id', $order_id)->first();
            }
        }

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this|null
     */
    public function updateData(array $data)
    {
        if ( ! empty($data)) {
            $this->order = $data;
        }

        $updated = \App\Models\Back\Orders\Order::where('id', $data['id'])->update([
            'payment_fname'       => $this->order['address']['fname'],
            'payment_lname'       => $this->order['address']['lname'],
            'payment_address'     => $this->order['address']['address'],
            'payment_zip'         => $this->order['address']['zip'],
            'payment_city'        => $this->order['address']['city'],
            'payment_state'       => $this->order['address']['state'],
            'payment_phone'       => $this->order['address']['phone'] ?: null,
            'payment_email'       => $this->order['address']['email'],
            'payment_method'      => $this->order['payment']->title,
            'payment_code'        => $this->order['payment']->code,
            'payment_card'        => '',
            'payment_installment' => '',
            'company'             => $this->order['address']['company'],
            'oib'                 => $this->order['address']['oib'],
            'comment'             => '',
            'approved'            => '',
            'approved_user_id'    => '',
            'updated_at'          => Carbon::now()
        ]);

        if ($updated) {
            $this->updateTotal($data['id']);

            return $this->setData($data['id']);
        }

        return null;
    }


    /**
     * @param int $order_id
     */
    private function updateTotal(int $order_id)
    {
        OrderTotal::where('order_id', $order_id)->delete();

        // SUBTOTAL
        OrderTotal::insert([
            'order_id'   => $order_id,
            'code'       => 'subtotal',
            'value'      => $this->order['cart']['subtotal'],
            'sort_order' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // CONDITIONS on Total
        foreach ($this->order['cart']['conditions'] as $name => $condition) {
            if ($condition->getType() == 'payment') {
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'payment',
                    'title'      => $name,
                    'value'      => $condition->parsedRawValue,
                    'sort_order' => $condition->getOrder(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            if ($condition->getType() == 'shipping') {
                OrderTotal::insert([
                    'order_id'   => $order_id,
                    'code'       => 'shipping',
                    'title'      => $name,
                    'value'      => $condition->parsedRawValue,
                    'sort_order' => $condition->getOrder(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        // TOTAL
        OrderTotal::insert([
            'order_id'   => $order_id,
            'code'       => 'total',
            'title'      => 'Sveukupno',
            'value'      => $this->order['cart']['total'],
            'sort_order' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        \App\Models\Back\Orders\Order::where('id', $order_id)->update([
            'total' => $this->order['cart']['total']
        ]);
    }


    /**
     * @param Product $model
     *
     * @return bool
     */
    public function checkSpecial(Product $model): bool
    {
        if ($model->special) {
            $from = now()->subDay();
            $to   = now()->addDay();

            if ($model->special_from && $model->special_from != '0000-00-00 00:00:00') {
                $from = Carbon::make($model->special_from);
            }
            if ($model->special_to && $model->special_to != '0000-00-00 00:00:00') {
                $to = Carbon::make($model->special_to);
            }

            if ($from <= now() && now() <= $to) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param Request $request
     *
     * @return mixed|null
     */
    public function finish(Request $request)
    {
        if ($this->isCreated()) {
            $method = new PaymentMethod($this->oc_data['payment_code']);

            return $method->finish($this->oc_data, $request);
        }

        return null;
    }


    /**
     * @return bool
     */
    public function isCreated(): bool
    {
        if ($this->oc_data) {
            return true;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function paymentNotRequired(): bool
    {
        if (in_array($this->oc_data->payment_code, ['cod', 'bank'])) {
            return true;
        }

        return false;
    }
}
