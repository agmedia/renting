<?php

namespace App\Http\Controllers\Back\Sales;

use App\Http\Controllers\Controller;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Orders\Deposit;
use App\Models\Back\Orders\Order;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Deposit $deposit)
    {
        $deposits = $deposit->filter($request)->with('order')->paginate(config('settings.pagination.back'));

        $statuses   = Settings::get('order', 'statuses');
        $payments   = Settings::getList('payment');

        return view('back.sales.deposit.index', compact('deposits', 'statuses', 'payments'));
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function api_status_change(Request $request, Deposit $deposit): JsonResponse
    {
        if ($request->has('deposits')) {
            $deposits = explode(',', substr($request->input('deposits'), 1, -1));

            $saved = $deposit->whereIn('id', $deposits)->update([
                'status_id' => $request->input('selected')
            ]);

            if ($saved) {
                return response()->json(['success' => __('back/app.save_success')]);
            }
        }

        return response()->json(['error' => __('back/app.save_failure')]);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store_deposit(Request $request, Deposit $deposit): JsonResponse
    {
        $saved = $deposit->validateRequest($request)->create();

        if ($saved) {
            return response()->json(['success' => __('back/app.save_success')]);
        }

        return response()->json(['error' => __('back/app.save_failure')]);
    }
}
