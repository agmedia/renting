<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Country;
use App\Http\Controllers\Controller;
use App\Models\Front\Checkout\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $countries = Country::list();

        return view('front.customer.index', compact('user', 'countries'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orWhere('payment_email', $user->email)->paginate(config('settings.pagination.front'));

        return view('front.customer.moje-narudzbe', compact('user', 'orders'));
    }


    /**
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, User $user)
    {
        $updated = $user->validateFrontRequest($request)->edit();

        if ($updated) {
            return redirect()->route('moj-racun', ['user' => $updated])->with(['success' => 'Korisnik je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Greška prilikom snimanja.']);
    }

}
