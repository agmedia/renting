<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Session\CheckoutSession;
use App\Http\Controllers\Controller;
use App\Mail\OrderReceived;
use App\Mail\OrderSent;
use App\Models\Back\Settings\Settings;
use App\Models\Front\AgCart;
use App\Models\Front\Checkout\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        } else {
            $order->createFrom($data);

            if ($order->isCreated()) {
                CheckoutSession::setOrder($order->getData());
            }
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
            //CheckoutSession::forgetOrder();
            //$this->shoppingCart()->flush();

            return redirect()->route('checkout.success');
        }

        return redirect()->route('checkout.error');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function success()
    {
        $data['order'] = CheckoutSession::getOrder();

        Log::info($data['order']);

        $this->dispatch(function () use ($data) {
            Mail::to(config('mail.admin'))->send(new OrderReceived($data['order']));
            Mail::to($data['order']['payment_email'])->send(new OrderSent($data['order']));
        });

        CheckoutSession::forgetOrder();
        $this->shoppingCart()->flush();

        return view('front.checkout.success', compact('data'));
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
                'address'  => CheckoutSession::getAddress(),
                'shipping' => CheckoutSession::getShipping(),
                'payment'  => CheckoutSession::getPayment()
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
