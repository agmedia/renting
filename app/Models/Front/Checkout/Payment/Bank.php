<?php

namespace App\Models\Front\Checkout\Payment;

use App\Models\Back\Orders\Order;
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

        $nhs_no = $this->order->id.'-'.date("ym");

        $pozivnabroj = $nhs_no;

        $total = number_format($this->order->total,2, ',', '');
        $_total = str_replace( ',', '', $total);


        $ukupnohub = number_format((float)$this->order->total, 2, '.', '');


        $data['firstname'] = $this->order->payment_fname;
        $data['lastname'] = $this->order->payment_lname;
        $data['address'] = $this->order->payment_address;
        $data['city'] = $this->order->payment_city;
        $data['country'] = $this->order->payment_state;
        $data['postcode'] = $this->order->payment_zip;
        $data['phone'] = $this->order->payment_phone;
        $data['email'] = $this->order->payment_email;


      //  $data['text_message'] = sprintf($this->language->get('text_bank'), $order_id, $total, $pozivnabroj);

        $hubstring = array (
            'renderer' => 'image',
            'options' =>
                array (
                    "format" => "jpg",
                    "scale" =>  3,
                    "ratio" =>  3,
                    "color" =>  "#2c3e50",
                    "bgColor" => "#fff",
                    "padding" => 20
                ),
            'data' =>
                array (
                    'amount' => floatval($ukupnohub),
                    'sender' =>
                        array (
                            'name' => $data['firstname'].' '.$data['lastname'],
                            'street' => $data['address'],
                            'place' => $data['postcode'].' '.$data['city'],
                        ),
                    'receiver' =>
                        array (
                            'name' => 'Fortuna d.o.o.',
                            'street' => 'Palmotićeva 28',
                            'place' => '10000 Zagreb',
                            'iban' => 'HR3123600001101595832',
                            'model' => '00',
                            'reference' => $pozivnabroj,
                        ),
                    'purpose' => 'CMDT',
                    'description' => 'Web narudžba Antikvarijat Biblos',
                ),
        );

        $postString = json_encode($hubstring);

        $url = 'https://hub3.bigfish.software/api/v1/barcode';
        $ch = curl_init($url);

        # Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        # Get the response

        $response = curl_exec($ch);
        curl_close($ch);



            $response = base64_encode($response);

              $data['uplatnica'] = $response;
        $scimg = 'data:image/png;base64,'.$response;
        list($type, $scimg) = explode(';', $scimg);
        list(, $scimg)      = explode(',', $scimg);
        $scimg = base64_decode($scimg);

        $path = $this->order->id.'.png';

        Storage::disk('qr')->put($path,  $scimg);


        return view('front.checkout.payment.bank', compact('data'));
    }


    /**
     * @param Order $order
     * @param null  $request
     *
     * @return bool
     */
    public function finishOrder(Order $order, $request = null): bool
    {
        $updated = $order->update([
            'order_status_id' => config('settings.order.status.new')
        ]);

        if ($updated) {
            return true;
        }

        return false;
    }

    public function mod11INI(string $nb)
    {
        $i = 0;
        $v = 0;
        $p = 2;
        $c = ' ';

        for ($i = strlen($nb); $i >= 1 ; $i--) {
            $c = substr($nb, $i - 1, 1);

            if ('0' <= $c && $c <= '9' && $v >= 0) {
                $v = $v + $p * $c;
                $p = $p + 1;
            } else {
                $v = -1;
            }
        }

        if ($v >= 0) {
            $v = 11 - ($v%11);

            if ($v > 9) {
                $v = 0;
            }
        }

        return $v;
    }

}
