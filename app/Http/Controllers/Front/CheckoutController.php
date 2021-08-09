<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Settings;
use App\Models\Front\AgCart;
use App\Models\Front\Checkout\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cart(Request $request)
    {
        return view('front.checkout.cart');
    }


    /**
     * @param Request $request
     * @param string  $step
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function checkout(Request $request)
    {
        $step = '';

        if ($request->has('step')) {
            $step = $request->input('step');
        }

        return view('front.checkout.checkout', compact('step'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        $data = $this->checkCheckoutSession();

        if (empty($data)) {
            return redirect()->route('naplata', ['step' => 'podaci']);
        }

        $shipping = Settings::getList('shipping')->where('code', $data['shipping'])->first();
        $payment = Settings::getList('payment')->where('code', $data['payment'])->first();

        //Log::info($data);

        return view('front.checkout.view', compact('data', 'shipping', 'payment'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function order(Request $request)
    {
        $data = $this->checkCheckoutSession();

        if (empty($data) || ! session()->has(config('session.cart'))) {
            return redirect()->route('kosarica');
        }

        $cart = new AgCart(session(config('session.cart')));
        $data['cart'] = $cart->get();

        $shipping = Settings::getList('shipping')->where('code', $data['shipping'])->first();
        $payment = Settings::getList('payment')->where('code', $data['payment'])->first();

        $data['shipping'] = $shipping;
        $data['payment'] = $payment;

        $order = new Order($data);
        $made = $order->make();

        if ($made) {
            $cart->flush();

            return view('front.checkout.success', compact('data'));
        }

        return view('front.checkout.error', compact('data'));
    }


    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    /**
     * @return array
     */
    private function checkCheckoutSession(): array
    {
        if (CheckoutSession::hasAddress() && CheckoutSession::hasShipping() && CheckoutSession::hasPayment()) {
            return [
                'address' => CheckoutSession::getAddress(),
                'shipping' => CheckoutSession::getShipping(),
                'payment' => CheckoutSession::getPayment()
            ];
        }

        return [];
    }
    
}
