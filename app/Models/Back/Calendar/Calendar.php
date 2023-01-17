<?php

namespace App\Models\Back\Calendar;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Front\Checkout\Checkout;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Calendar extends Model
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
     * @return HasOne
     */
    public function apartment(): HasOne
    {
        return $this->hasOne(Apartment::class, 'id', 'apartment_id');
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function updateOrder(Request $request)
    {
        $data = $request['data']['extendedProps'];

        $sorted_request = new Request([
            'apartment_id' => $data['order']['apartment_id'],
            'dates'        => Carbon::make($request['data']['start'])->format('Y-m-d') . ' - ' . Carbon::make($request['data']['end'])->format('Y-m-d'),
            'adults'       => $data['order_options']['adults'],
            'children'     => $data['order_options']['children'],
            'firstname'    => $data['order']['payment_fname'],
            'lastname'     => $data['order']['payment_lname'],
            'phone'        => $data['order']['payment_phone'],
            'email'        => $data['order']['payment_email'],
            'payment_type' => $data['order']['payment_method']
        ]);

        $order    = Order::find($data['order']['id']);
        $checkout = new Checkout($sorted_request);

        return $order->setCheckoutData($checkout)->store($order->id);
    }


    /**
     * @param Request $request
     *
     * @return false
     */
    public function storeServiceOrder(Request $request): bool
    {
        $name = 'Service';

        if (isset($request['data']['title'])) {
            $name = $request['data']['title'];
        }

        Log::info($name);

        $id = Order::insertGetId([
            'apartment_id'     => $request['data']['apartment_id'],
            'user_id'          => 0,
            'affiliate_id'     => 0,
            'order_status_id'  => config('settings.order.status.paid'),
            'invoice'          => 'service',
            'total'            => 0,
            'date_from'        => Carbon::make($request['data']['date']),
            'date_to'          => Carbon::make($request['data']['date'])->addDay(),
            'payment_fname'    => $name,
            'payment_lname'    => 'Service',
            'payment_email'    => 'service@service.com',
            'payment_phone'    => '00000000',
            'payment_method'   => 'cod',
            'payment_code'     => 'service',
            'company'          => '',
            'oib'              => '',
            'options'          => '',
            'comment'          => 'Service',
            'sync_uid'         => '',
            'approved'         => '',
            'approved_user_id' => '',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            OrderHistory::store($id);

            $order = Order::find($id);

            $sorted_request = new Request([
                'apartment_id' => $order->apartment_id,
                'dates'        => Carbon::make($order->date_from)->format('Y-m-d') . ' - ' . Carbon::make($order->date_to)->format('Y-m-d'),
                'adults'       => 1,
                'children'     => 0,
                'firstname'    => $name,
                'lastname'     => 'Service',
                'phone'        => '00000000',
                'email'        => 'service@service.com',
                'payment_type' => 'bank'
            ]);

            $checkout = new Checkout($sorted_request);

            $order->setCheckoutData($checkout)->store($order->id);

            return true;
        }

        return false;
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = (new Calendar())->newQuery();

        return $query;
    }

}
