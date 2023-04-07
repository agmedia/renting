<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\FrontBaseController;
use App\Models\Front\Checkout\Deposit;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Checkout\Checkout;
use App\Models\Front\Checkout\Order;
use App\Models\TagManager;
use App\Models\User;
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
        $this->checkIfUserWantsToRegister($request);

        $checkout     = new Checkout($request);
        $has_order_id = CheckoutSession::hasOrder() ? CheckoutSession::getOrder() : 0;
        $order        = (new Order())->setId($has_order_id)->resolveMissing($checkout);
        $form         = $order->resolvePaymentForm();

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

        $order   = Order::query()->where('hash', $request->input('signature'))->first();
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

            $order->total          = $deposit->amount;
            $order->payment_method = $deposit->payment_code;
            $order->payment_code   = $deposit->payment_code;
            $order->deposit        = $deposit;
            $order->comment        = $order->deposit->comment;
        }

        $apartment = Apartment::query()->where('id', $order->apartment_id)->first();

        if ( ! $apartment) {
            return redirect()->route('index');
        }

        $checkout_request = Helper::setCheckoutRequest($request, $order->toArray());
        $checkout         = new Checkout($checkout_request);

        $checkout->setPayment($order->payment_method);

        $order->identificator = $order->id;

        $form_options = [];
        if ($deposit) {
            $form_options         = ['order_number' => $order->id . '-' . $deposit->id];
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
            // Check if it's a deposit
            $deposit = $this->checkResolveIfDeposit($request);

            if ($deposit) {
                return view('front.checkout.success');
            }

            return redirect()->route('index')->with('error', __('front/common.message_error'));
        }

        // Check if it's an order
        $order = $this->resolveSuccessOrder($request);

        if ($order) {
            $checkout = CheckoutSession::getCheckout();
            $checkout = unserialize($checkout);
            $checkout['is_deposit'] = false;
            $checkout = serialize($checkout);

            $order->updateStatus('new')->finish($request);
            $order->sendNewOrderEmails($checkout);

            CheckoutSession::forget();

            return view('front.checkout.success', compact('order', 'checkout'));
        }

        // Check if it's a deposit
        $deposit = $this->checkResolveIfDeposit($request);

        if ($deposit) {
            return view('front.checkout.success');
        }

        $apartment = $this->getRedirectData('apartment');

        return redirect()->route('apartment', ['apartment' => $apartment->translation->slug])->with('error', __('front/common.message_error'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function resolveSuccessOrder(Request $request)
    {
        $ids = explode('-', $request->input('order_number'));

        if (isset($ids[1])) {
            return false;
        }

        return Order::where('id', $request->input('order_number'))->first();
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function checkResolveIfDeposit(Request $request)
    {
        $deposit = $this->resolveSuccessDeposit($request);

        if ($deposit) {
            $deposit->setStatus('pending')->finishTransaction($request)->sendEmails();

            return true;
        }

        return false;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    private function resolveSuccessDeposit(Request $request)
    {
        $ids     = explode('-', $request->input('order_number'));
        return Deposit::query()->where('id', $ids[1])->where('order_id', $ids[0])->first();
    }


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
     *
     * @return false|null
     */
    private function checkIfUserWantsToRegister(Request $request)
    {
        if ($request->has('register_user') &&
            $request->input('register_user') == 'on' &&
            $request->has('terms') &&
            $request->input('terms') == 'on') {

            $user = new User();
            $user = $user->setCheckoutRegisteredUser($request)->make();

            auth()->login($user);

            return $user;
        }

        return false;
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
