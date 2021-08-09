<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Country;
use App\Http\Controllers\Controller;
use App\Models\Back\Orders\Order;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Order())->newQuery();

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where('payment_fname', 'like', '%' . $request->input('search'))
                  ->orWhere('payment_lname', 'like', '%' . $request->input('search'))
                  ->orWhere('payment_city', 'like', '%' . $request->input('search'))
                  ->orWhere('payment_email', 'like', '%' . $request->input('search'));
        }

        $orders = $query->paginate(20);

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
        dd($request);
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
        $statuses = Settings::get('order', 'statuses');
        $shippings = Settings::getList('shipping');
        $payments = Settings::getList('payment');

        return view('back.order.edit', compact('order', 'countries', 'statuses', 'shippings', 'payments'));
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
        dd($request);
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {}


    public function api_status_change(Request $request)
    {
        $orders = explode(',', substr($request->input('orders'), 1, -1));

        Order::whereIn('id', $orders)->update([
            'order_status_id' => $request->input('selected')
        ]);

        return response()->json($request->toArray());
    }
}
