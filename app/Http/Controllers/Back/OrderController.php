<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Country;
use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderHistory;
use App\Models\Back\Orders\OrderTotal;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Checkout\Checkout;
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

        /*$stored = $order->validateRequest($request)->store();

        if ($stored) {
            return redirect()->route('orders.edit', ['order' => $stored])->with(['success' => __('back/app.save_success')]);
        }*/

        return redirect()->back()->with(['error' => __('back/app.save_failure')]);
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
        $countries  = Country::list();
        $statuses   = Settings::get('order', 'statuses');
        $payments   = Settings::getList('payment');
        $apartments = Apartment::query()->where('status', 1)->get();

        return view('back.order.edit', compact('order', 'countries', 'statuses', 'payments', 'apartments'));
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
        //dd($request->toArray());
        $order->validateRequest($request)->checkDates();

        $checkout = new Checkout($request);
        $updated  = $order->setCheckoutData($checkout)->store($order->id);

        //dd($checkout, $request->toArray(), $checkout->cleanData());

        if ($updated) {
            return redirect()->route('orders.edit', ['order' => $updated])->with(['success' => __('back/app.save_success')]);
        }

        return redirect()->back()->with(['error' => __('back/app.save_failure')]);
    }


    /**
     * Remove the specified order from storage.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->completeDelete();

        return redirect()->back()->with(['success' => __('back/app.save_success')]);
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

            return response()->json(['message' => __('back/app.save_success')]);
        }

        if ($request->has('order_id')) {
            if ($request->has('status') && $request->input('status')) {
                Order::where('id', $request->input('order_id'))->update([
                    'order_status_id' => $request->input('status')
                ]);
            }

            OrderHistory::store($request->input('order_id'), $request);

            return response()->json(['message' => __('back/app.save_success')]);
        }

        return response()->json(['error' => __('back/app.save_failure')]);
    }
}
