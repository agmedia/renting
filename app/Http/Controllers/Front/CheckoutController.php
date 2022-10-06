<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Mail\OrderReceived;
use App\Mail\OrderSent;
use App\Models\Back\Settings\Settings;
use App\Models\Front\AgCart;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Checkout\Checkout;
use App\Models\Front\Checkout\Order;
use App\Models\Seo;
use App\Models\TagManager;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Front\Checkout\PaymentMethod;
use App\Models\Front\Checkout\GeoZone;

class CheckoutController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        /*if ( ! $request->input('dates')) {
            return redirect()->back()->with('error', 'Enter dates!');
        }*/

        $checkout = new Checkout($request);
        $options  = $checkout->apartment->options()->withoutPersons()->get();

        CheckoutSession::hasAddress() ? $checkout->setAddress(CheckoutSession::getAddress()) : null;
        CheckoutSession::hasPayment() ? $checkout->setPayment(CheckoutSession::getPayment()) : null;

        return view('front.checkout.checkout', compact('checkout', 'options'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function checkoutView(Request $request)
    {
        /*if ( ! $request->input('dates')) {
            return redirect()->back()->with('error', 'Enter dates!');
        }*/

        $checkout = new Checkout($request);
        $order = new Order();
        $form = $order->createMissing($checkout)->resolvePaymentForm();

        CheckoutSession::setAddress($checkout->setAddress());
        CheckoutSession::setPayment($checkout->setPayment());
        CheckoutSession::setCheckout(get_object_vars($checkout));
        CheckoutSession::setOrder($order->id);

        //dd(CheckoutSession::getCheckout(), $form->data);

        return view('front.checkout.checkout-preview', compact('checkout', 'form'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function success(Request $request)
    {
        dd($request, CheckoutSession::getCheckout());

        /**
         *
         */
        $data['order'] = CheckoutSession::getOrder();

        if ( ! $data['order']) {
            return redirect()->route('front.checkout.checkout', ['step' => '']);
        }

        $order = \App\Models\Back\Orders\Order::where('id', $data['order']['id'])->first();

        if ($order) {
            dispatch(function () use ($order) {
                Mail::to(config('mail.admin'))->send(new OrderReceived($order));
                Mail::to($order->payment_email)->send(new OrderSent($order));
            });

            foreach ($order->products as $product) {
                $product->real->decrement('quantity', $product->quantity);

                if ( ! $product->real->quantity) {
                    $product->real->update([
                        'status' => 0
                    ]);
                }
            }

            CheckoutSession::forgetOrder();
            CheckoutSession::forgetStep();
            CheckoutSession::forgetPayment();
            CheckoutSession::forgetShipping();
            $this->shoppingCart()->flush();

            $data['google_tag_manager'] = Seo::getGoogleDataLayer($order);

            return view('front.checkout.success', compact('data'));
        }

        return redirect()->route('front.checkout.checkout');
    }









    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

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
    public function checkout_orig(Request $request)
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
        $data = $this->checkSession();

        if (empty($data)) {
            if ( ! session()->has(config('session.cart'))) {
                return redirect()->route('kosarica');
            }

            return redirect()->route('naplata', ['step' => 'podaci']);
        }

        $data = $this->collectData($data, config('settings.order.status.unfinished'));

        $order = new Order();

        if (CheckoutSession::hasOrder()) {
            $data['id'] = CheckoutSession::getOrder()['id'];

            $order->updateData($data);
            $order->setData($data['id']);

        } else {
            $order->createFrom($data);
        }

        if ($order->isCreated()) {
            CheckoutSession::setOrder($order->getData());
        }

        $data['payment_form'] = $order->resolvePaymentForm();

        return view('front.checkout.view', compact('data'));
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function order(Request $request)
    {
        $order = new Order();

        if ($request->has('provjera')) {
            $order->setData($request->input('provjera'));
        }

        if ($request->has('ShoppingCartID')) {
            $order->setData($request->input('ShoppingCartID'));
        }

        if ($order->finish($request)) {
            return redirect()->route('checkout.success');
        }

        return redirect()->route('checkout.error');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function error()
    {
        return view('front.checkout.error');
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return array
     */
    private function checkSession(): array
    {
        if (CheckoutSession::hasAddress() && CheckoutSession::hasShipping() && CheckoutSession::hasPayment()) {
            return [
                'address' => CheckoutSession::getAddress(),
                'payment' => CheckoutSession::getPayment()
            ];
        }

        return [];
    }


    /**
     * @param array $data
     * @param int   $order_status_id
     *
     * @return array
     */
    private function collectData(array $data, int $order_status_id): array
    {
        $shipping = Settings::getList('shipping')->where('code', $data['shipping'])->first();
        $payment  = Settings::getList('payment')->where('code', $data['payment'])->first();

        $response                    = [];
        $response['address']         = $data['address'];
        $response['shipping']        = $shipping;
        $response['payment']         = $payment;
        $response['cart']            = $this->shoppingCart()->get();
        $response['order_status_id'] = $order_status_id;

        return $response;
    }


    /**
     * @return AgCart
     */
    private function shoppingCart(): AgCart
    {
        return new AgCart(session(config('session.cart')));
    }

}
