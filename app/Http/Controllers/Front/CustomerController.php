<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Country;
use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontBaseController;
use App\Models\Front\AgCart;
use App\Models\Front\Checkout\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends FrontBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->checkUser();
        $countries = Country::list();

        CheckoutSession::forgetAddress();

        return view('front.customer.index', compact('user', 'countries'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orders(Request $request)
    {
        $user = $this->checkUser();
        $orders = Order::query()
                       ->where('user_id', $user->id)
                       ->orWhere('payment_email', $user->email)
                       ->with('apartment', 'deposits', 'totals')
                       ->paginate(config('settings.pagination.front'));

        //dd($orders->first()->reservation);

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
        $this->checkUser();

        $updated = $user->validateFrontRequest($request)->edit();

        if ($updated) {
            return redirect()->route('moj-racun', ['user' => $updated])->with(['success' => 'Korisnik je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Greška prilikom snimanja.']);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    private function checkUser()
    {
        if (auth()->guest()) {
            return redirect()->route('index');
        }

        return auth()->user();
    }

}
