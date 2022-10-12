<?php

namespace App\Models\Back\Orders;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Settings\Settings;
use App\Models\Back\Users\Client;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['checkout'];

    /**
     * @var Request
     */
    protected $request;


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
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apartment()
    {
        return $this->hasOne(Apartment::class, 'id', 'apartment_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id')->orderBy('created_at');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(OrderTotal::class, 'order_id')->orderBy('sort_order');
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->where('order_status_id', 3)->orWhere('order_status_id', 4);
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLast($query, $count = 9)
    {
        return $query->whereIn('order_status_id', [4, 5, 6, 7])->orderBy('created_at', 'desc')->limit($count);
    }


    /**
     * @param       $query
     * @param array $params
     *
     * @return mixed
     */
    public function scopeChartData($query, array $params)
    {
        return $query
            ->whereBetween('created_at', [$params['from'], $params['to']])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) use ($params) {
                return \Illuminate\Support\Carbon::parse($val->created_at)->format($params['group']);
            });
    }


    /**
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'payment' => 'required',
            //'dates'   => 'required',
            'fname'   => 'required',
            'lname'   => 'required',
            'email'   => 'required',
        ]);

        $this->setRequest($request);

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
     * @return mixed
     */
    public function getCheckoutAttribute()
    {
        return unserialize($this->options);
    }


    /**
     * @param null $id
     *
     * @return bool
     */
    public function store($id = null)
    {
        $order = $id ? $this->updateData($id) : $this->storeData();

        if ($order) {
            //OrderTotal::store(json_decode($this->request->sums), $order->id);

            return $order;
        }

        return false;
    }


    /**
     * @return bool
     */
    private function storeData()
    {
        $payment = Settings::get('payment', 'list.' . $this->request->payment)->first();

        $id = $this->insertGetId([
            'payment_fname'  => $this->request->fname,
            'payment_lname'  => $this->request->lname,
            'payment_email'  => $this->request->email,
            'payment_method' => $payment->code,
            'payment_code'   => $payment->code,
            'company'        => isset($this->request->company) ? $this->request->company : null,
            'oib'            => isset($this->request->oib) ? $this->request->oib : null,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now()
        ]);

        if ($id) {
            OrderHistory::store($id);

            return $this->find($id);
        }

        return false;
    }


    /**
     * @param $id
     *
     * @return bool
     */
    private function updateData($id)
    {
        $payment = Settings::get('payment', 'list.' . $this->request->payment)->first();

        if ($this->request->dates) {
            $dates = explode(' - ', $this->request->dates);
            $from  = Carbon::make($dates[0]);
            $to    = Carbon::make($dates[1]);

            $this->where('id', $id)->update([
                'date_from' => $from,
                'date_to'   => $to,
            ]);
        }

        //dd($payment, $this->request);

        $updated = $this->where('id', $id)->update([
            'total'          => $this->request->payment_amount,
            'payment_fname'  => $this->request->fname,
            'payment_lname'  => $this->request->lname,
            'payment_email'  => $this->request->email,
            'payment_method' => $payment->code,
            'payment_code'   => $payment->code,
            'company'        => isset($this->request->company) ? $this->request->company : null,
            'oib'            => isset($this->request->oib) ? $this->request->oib : null,
            'updated_at'     => Carbon::now()
        ]);

        if ($updated) {
            $order = $this->find($id);

            /*$request = new Request([
                'status'  => 0,
                'comment' => 'Izmjenjeni podaci narudžbe.!'
            ]);

            OrderHistory::store($id, $request);*/

            return $order;
        }

        return false;
    }


    /**
     * Set Model request variable.
     *
     * @param $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getLatest($count = 15)
    {
        $query = (new Order())->newQuery();

        return $query->with('status')->orderBy('id', 'desc')->limit($count)->get();
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
            $query->where('order_status_id', '=', $request->input('status'));
        }

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search') . '%')
                      ->orWhere('payment_fname', 'like', '%' . $request->input('search'))
                      ->orWhere('payment_lname', 'like', '%' . $request->input('search'))
                      ->orWhere('payment_email', 'like', '%' . $request->input('search'));
            });
        }

        return $query->orderBy('created_at', 'desc');
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public static function trashComplete($id)
    {
        OrderProduct::where('order_id', $id)->delete();
        OrderTotal::where('order_id', $id)->delete();
        Transaction::where('order_id', $id)->delete();

        return self::where('id', $id)->delete();
    }
}
