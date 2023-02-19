<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontBaseController;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Checkout\Checkout;
use App\Models\Front\Checkout\Order;
use App\Models\TagManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends FrontBaseController
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $this->validateCheckout($request);

        $checkout     = new Checkout($request);
        $options      = $checkout->getOptions();
        $auto_options = $checkout->getAutoInsertOptions();

        CheckoutSession::hasAddress() ? $checkout->setAddress(CheckoutSession::getAddress()) : null;
        CheckoutSession::hasPayment() ? $checkout->setPayment(CheckoutSession::getPayment()) : null;

        CheckoutSession::setCheckout(serialize($checkout->cleanData()));

        return view('front.checkout.checkout', compact('checkout', 'options', 'auto_options'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function checkoutView(Request $request)
    {
        $this->validateCheckout($request, true);

        $checkout = new Checkout($request);
        $order_id = CheckoutSession::hasOrder() ? CheckoutSession::getOrder() : 0;
        $order    = (new Order())->setId($order_id)->resolveMissing($checkout);
        $form     = $order->resolvePaymentForm();

        CheckoutSession::set($checkout, $order);

        return view('front.checkout.checkout-preview', compact('checkout', 'order', 'form'));
    }


    public function checkoutSpecial(Request $request)
    {
        if ( ! $request->has('generator')) {
            return redirect()->route('index');
        }

        $order = Order::query()->where('hash', $request->input('generator'))->first();

        if ( ! $order) {
            return redirect()->route('index');
        }

        $apartment = Apartment::query()->where('id', $order->apartment_id)->first();

        if ( ! $apartment) {
            return redirect()->route('index');
        }

        $checkout_request = $this->setCheckoutRequest($request, $order->toArray());
        $checkout         = new Checkout($checkout_request);

        $checkout->setPayment($order->payment_method);

        $form = $order->setCheckout($checkout)->resolvePaymentForm();

        CheckoutSession::set($checkout, $order);

        return view('front.checkout.checkout-special', compact('apartment', 'order', 'form'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function success(Request $request)
    {
        if ( ! CheckoutSession::hasOrder() && ! CheckoutSession::hasCheckout()) {
            return redirect()->route('index')->with('error', __('front/common.message_error'));
        }

        $order = Order::unfinished()->where('id', CheckoutSession::getOrder())->first();

        if ($order) {
            $order->updateStatus('new')->finish($request);
            $checkout = CheckoutSession::getCheckout();

            $order->sendNewOrderEmails($checkout);

            CheckoutSession::forget();

            return view('front.checkout.success', compact('order', 'checkout'));
        }

        $apartment = $this->getRedirectData('apartment');

        return redirect()->route('apartment', ['apartment' => $apartment])->with('error', __('front/common.message_error'));
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param Request $request
     * @param bool    $view
     *
     * @return void
     */
    private function validateCheckout(Request $request, bool $view = false): void
    {
        $request->validate([
            'aid'   => 'required',
            'dates' => 'required',
        ]);

        if ($view) {
            $request->validate([
                'firstname' => 'required',
                'lastname'  => 'required',
                'phone'     => 'required',
                'email'     => 'required',
            ]);

            $request->merge(['apartment_id' => $request->input('aid')]);
        }

        if ( ! $view) {
            $request->merge(['apartment_id' => decrypt_apartment($request->input('aid'))]);
        }
    }


    /**
     * @param Request $request
     * @param array   $order
     *
     * @return Request
     */
    private function setCheckoutRequest(Request $request, array $order): Request
    {
        return $request->merge([
            'apartment_id' => $order['apartment_id'],
            'aid'          => $order['apartment_id'],
            'dates'        => Carbon::make($order['date_from'])->format('Y-m-d') . ' - ' . Carbon::make($order['date_to'])->format('Y-m-d'),
            'firstname'    => $order['payment_fname'],
            'lastname'     => $order['payment_lname'],
            'phone'        => $order['payment_phone'],
            'email'        => $order['payment_email'],
            'payment_type' => $order['payment_method']
        ]);
    }


    /**
     * @param string $target
     *
     * @return mixed|null
     */
    private function getRedirectData(string $target)
    {
        if ($target == 'apartment') {
            $response = CheckoutSession::getCheckout()['apartment'];
        }

        return $response ?: null;
    }

}
