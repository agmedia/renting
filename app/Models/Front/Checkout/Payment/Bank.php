<?php

namespace App\Models\Front\Checkout\Payment;

use App\Models\Front\Checkout\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class Bank
 * @package App\Models\Front\Checkout\Payment
 */
class Bank
{

    /**
     * @var int
     */
    private $order;


    /**
     * Cod constructor.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }


    /**
     * @param null $payment_method
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function resolveFormView($payment_method = null)
    {
        $data['order_id'] = $this->order->id;
        $nhs_no           = $this->order->id . '-' . date("ym");
        $pozivnabroj      = $nhs_no;

        $total            = str_replace('.', '', number_format($this->order->total, 2, '.', ''));

        $data['firstname'] = $this->order->checkout->firstname;
        $data['lastname']  = $this->order->checkout->lastname;
        $data['telephone'] = $this->order->checkout->phone;
        $data['email']     = $this->order->checkout->email;

        $hubstring = array(
            'renderer' => 'image',
            'options'  =>
                array(
                    "format"  => "jpg",
                    "scale"   => 3,
                    "ratio"   => 3,
                    "color"   => "#2c3e50",
                    "bgColor" => "#fff",
                    "padding" => 20
                ),
            'data'     =>
                array(
                    'amount'      => intval($total),
                    'currency' => 'EUR',
                    'sender'      =>
                        array(
                            'name'   => $data['firstname'] . ' ' . $data['lastname'],
                            'street' => '',//$data['address'],
                            'place'  => '',//$data['postcode'].' '.$data['city'],

                        ),
                    'receiver'    =>
                        array(
                            'name'      => 'SelfCheckIns LTD',
                            'street'    => '20-22 Wenlock Road',
                            'place'     => 'N1 7GU London',
                            'iban'      => 'HR4723900011101317916',
                            'model'     => '00',
                            'reference' => $pozivnabroj,
                        ),
                    'purpose'     => 'CMDT',
                    'description' => 'SelfCheckIns',
                ),
        );

        $postString = json_encode($hubstring);

        $url = 'https://hub3.bigfish.software/api/v2/barcode';
        $ch  = curl_init($url);

        # Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        # Get the response

        $response = curl_exec($ch);
        curl_close($ch);

        $response = base64_encode($response);

        $data['uplatnica'] = $response;
        $scimg             = 'data:image/png;base64,' . $response;

        list($type, $scimg) = explode(';', $scimg);
        list(, $scimg) = explode(',', $scimg);

        $scimg = base64_decode($scimg);
        $path  = $this->order->id . '.png';

        Storage::disk('qr')->put($path, $scimg);

        return view('front.checkout.payment.bank', compact('data'));
    }


    /**
     * @param Order   $order
     * @param Request $request
     *
     * @return bool
     */
    public function finishOrder(Order $order, Request $request): bool
    {
        $updated = true;

        if ($updated) {
            return true;
        }

        return false;
    }

}
