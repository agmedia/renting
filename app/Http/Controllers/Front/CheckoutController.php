<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontBaseController;
use App\Models\Back\Orders\Deposit;
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


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkoutSpecial(Request $request)
    {
        if ( ! $request->has('signature')) {
            return redirect()->route('index');
        }

        $order = Order::query()->where('hash', $request->input('signature'))->first();
        $deposit = null;

        if ( ! $order) {
            $deposit = Deposit::query()->where('signature', $request->input('signature'))->first();

            if ( ! $deposit) {
                return redirect()->route('index');
            }

            $order = Order::find($deposit->order_id);

            if ( ! $order) {
                return redirect()->route('index');
            }

            $order->total = $deposit->amount;
            $order->payment_method = $deposit->payment_code;
            $order->payment_code = $deposit->payment_code;
            $order->deposit = $deposit;
            $order->comment = $order->deposit->comment;
        }

        $apartment = Apartment::query()->where('id', $order->apartment_id)->first();

        if ( ! $apartment) {
            return redirect()->route('index');
        }

        $checkout_request = $this->setCheckoutRequest($request, $order->toArray());
        $checkout         = new Checkout($checkout_request);

        $checkout->setPayment($order->payment_method);

        $order->identificator = $order->id;

        $form_options = [];
        if ($deposit) {
            $form_options = ['order_number' => $order->id . '-' . $deposit->id];
            $order->identificator = $order->id . '-' . $deposit->id;
        }

        $form = $order->setCheckout($checkout)->resolvePaymentForm($form_options);

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

        $order = $this->resolveSuccessOrder($request);

        if ($order) {
            $checkout = CheckoutSession::getCheckout();

            if ( ! $order->is_deposit) {
                $order->updateStatus('new')->finish($request);
                $order->sendNewOrderEmails($checkout);
            }

            CheckoutSession::forget();

            return view('front.checkout.success', compact('order', 'checkout'));
        }

        $apartment = $this->getRedirectData('apartment');

        return redirect()->route('apartment', ['apartment' => $apartment])->with('error', __('front/common.message_error'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function resolveSuccessOrder(Request $request)
    {
        $order = Order::where('id', $request->input('order_number'))->first();
        $order->is_deposit = false;

        if ( ! $order) {
            $ids = explode('-', $request->input('order_number'));

            $order = Order::where('id', $ids[0])->first();

            if ( ! $order) {
                return false;
            }

            $order->is_deposit = true;
            $order->deposit = Deposit::query()->where('id', $ids[1])->first();
        }

        return $order;
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
        if ($target == 'apartment' && isset(CheckoutSession::getCheckout()['apartment'])) {
            return CheckoutSession::getCheckout()['apartment'];
        }

        return Apartment::query()->inRandomOrder()->first();
    }

}
