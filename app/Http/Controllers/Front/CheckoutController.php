<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Models\Front\Checkout\Checkout;
use App\Models\Front\Checkout\Order;
use App\Models\TagManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $this->validateCheckout($request);

        $checkout = new Checkout($request);
        $options  = $checkout->getOptions();
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
    public function success(Request $request)
    {
        if ( ! CheckoutSession::hasOrder() && ! CheckoutSession::hasCheckout()) {
            return redirect()->route('index')->with('error', 'Nešto je pošlo po zlu, molimo pokušajte ponovo ili kontaktirajte administratora.');
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

        return redirect()->route('apartment', ['apartment' => $apartment])->with('error', 'Nešto je pošlo po zlu, molimo pokušajte ponovo ili kontaktirajte administratora.');
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
