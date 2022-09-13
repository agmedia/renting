<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Country;
use App\Http\Controllers\Controller;
use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        if ($request->has('insert_count')) {
            $count = intval($request->input('insert_count'));
            $from  = Carbon::now()->subWeek();
            $to    = Carbon::now()->addDays(3);

            for ($i = 0; $i < $count; $i++) {
                $total = 1550;

                $id = Order::insertGetId([
                    'apartment_id'        => 2,
                    'user_id'             => 0,
                    'affiliate_id'        => 0,
                    'order_status_id'     => 1,
                    'invoice'             => null,
                    'total'               => $total,
                    'date_from'           => $from,
                    'date_to'             => $to,
                    'payment_fname'       => 'Ime',
                    'payment_lname'       => 'Prezima',
                    'payment_address'     => 'Neka adresa',
                    'payment_zip'         => '10000',
                    'payment_city'        => 'Zagreb',
                    /*'payment_state'       => 'Croatia',*/
                    'payment_phone'       => '9999999999',
                    'payment_email'       => 'ime.prezima@test.hr',
                    'payment_method'      => 'wspay',
                    'payment_code'        => '',
                    'payment_card'        => 'VISA',
                    'payment_installment' => 0,
                    'company'             => '',
                    'oib'                 => '',
                    'approved'            => false,
                    'approved_user_id'    => 0,
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now()
                ]);

                $from     = $to->addDay();
                $to       = $from->addDays(10);
                $subtotal = $total / 1.25;

                $totals = [
                    'subtotal' => $subtotal,
                    'tax'      => $total - $subtotal,
                    'total'    => $total
                ];

                $itt = 0;

                foreach ($totals as $key => $total) {
                    OrderTotal::insertGetId([
                        'order_id'   => $id,
                        'code'       => $key,
                        'value'      => $total,
                        'sort_order' => $itt,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $itt++;
                }
            }
        }

        $orders = $order->filter($request)->paginate(config('settings.pagination.back'));

        $statuses = Settings::get('order', 'statuses');

        return view('back.order.index', compact('orders', 'statuses'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.order.edit');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();

        $stored = $order->validateRequest($request)->store();

        if ($stored) {
            return redirect()->route('orders.edit', ['order' => $stored])->with(['success' => 'Narudžba je snimljena!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Dogodila se greška prilikom snimanja.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $statuses = Settings::get('order', 'statuses');

        return view('back.order.show', compact('order', 'statuses'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $countries = Country::list();
        $statuses  = Settings::get('order', 'statuses');
        $payments  = Settings::getList('payment');

        return view('back.order.edit', compact('order', 'countries', 'statuses', 'payments'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Order                    $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        dd($request, $order);

        $updated = $order->validateRequest($request)->store($order->id);

        if ($updated) {
            return redirect()->route('orders.edit', ['order' => $updated])->with(['success' => 'Narudžba je snimljena!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Dogodila se greška prilikom snimanja.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_status_change(Request $request)
    {
        if ($request->has('orders')) {
            $orders = explode(',', substr($request->input('orders'), 1, -1));

            Order::whereIn('id', $orders)->update([
                'order_status_id' => $request->input('selected')
            ]);

            return response()->json(['message' => 'Statusi su uspješno promijenjeni..!']);
        }

        if ($request->has('order_id')) {
            if ($request->has('status') && $request->input('status')) {
                Order::where('id', $request->input('order_id'))->update([
                    'order_status_id' => $request->input('status')
                ]);
            }

            OrderHistory::store($request->input('order_id'), $request);

            return response()->json(['message' => 'Status je uspješno promijenjen..!']);
        }

        return response()->json(['error' => 'Greška..! Molimo pokušajte ponovo ili kontaktirajte administratora..']);
    }
}
