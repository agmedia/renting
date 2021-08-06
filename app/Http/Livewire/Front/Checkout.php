<?php

namespace App\Http\Livewire\Front;

use App\Helpers\Country;
use App\Helpers\Session\CheckoutSession;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Checkout\GeoZone;
use App\Models\Front\Checkout\ShippingMethod;
use Livewire\Component;

class Checkout extends Component
{

    /**
     * @var string
     */
    public $step = '';

    /**
     * @var string[]
     */
    public $address = [
        'fname' => '',
        'lname' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'city' => '',
        'zip' => '',
        'state' => '',
    ];

    /**
     * @var string
     */
    public $shipping = '';

    /**
     * @var string
     */
    public $payment = '';

    /**
     * @var string[]
     */
    protected $address_rules = [
        'address.fname' => 'required',
        'address.lname' => 'required',
        'address.email' => 'required|email',
        'address.address' => 'required',
        'address.city' => 'required',
        'address.zip' => 'required',
        'address.state' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $shipping_rules = [
        'shipping' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $payment_rules = [
        'payment' => 'required',
    ];

    /**
     * @var \string[][]
     */
    protected $queryString = ['step' => ['except' => '']];


    /**
     *
     */
    public function mount()
    {
        //session()->forget('checkout.address');
        if (CheckoutSession::hasAddress()) {
            $this->setAddress(CheckoutSession::getAddress());
        } else {
            $this->setAddress();
        }

        if (CheckoutSession::hasShipping()) {
            $this->shipping = CheckoutSession::getShipping();
            //dd($this->shipping);
            //dd($this->address['state']);
            //dd((new GeoZone())->findState($this->address['state'])['id']);
            //dd((new ShippingMethod())->findGeo((new GeoZone())->findState($this->address['state'])['id']));
        }

        if (CheckoutSession::hasPayment()) {
            $this->payment = CheckoutSession::getPayment();
        }

        $this->changeStep($this->step);
    }


    /**
     * @param string $step
     */
    public function changeStep(string $step = '')
    {
        // Podaci
        if ($step == '') {
            $step = 'podaci';

            if (CheckoutSession::hasStep()) {
                $step = CheckoutSession::getStep();
            }
        }

        // Dostava
        if (in_array($step, ['dostava', 'placanje'])) {
            $this->validate($this->address_rules);
        }

        // Plaćanje
        if ($step == 'placanje') {
            $this->validate($this->shipping_rules);
        }

        $this->step = $step;

        CheckoutSession::setStep($step);
    }


    /**
     * @param string $state
     */
    public function stateSelected(string $state)
    {
        //dd($state);
        $value['state'] = $state;

        $this->setAddress($value, true);

        $this->render();
    }


    /**
     * @param string $shipping
     */
    public function selectShipping(string $shipping)
    {
        $this->shipping = $shipping;

        CheckoutSession::setShipping($shipping);

        //$this->emit('shipping_selected');
        return redirect()->route('naplata', ['step' => 'dostava']);
    }


    /**
     * @param string $payment
     */
    public function selectPayment(string $payment)
    {
        $this->payment = $payment;

        CheckoutSession::setPayment($payment);
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $geo = (new GeoZone())->findState($this->address['state']);

        //dd($geo);
        //dd($geo);

        return view('livewire.front.checkout', [
            'shippingMethods' => (new ShippingMethod())->findGeo($geo['id']),
            'paymentMethods' => Settings::getList('payment'),
            'countries' => Country::list()
        ]);
    }


    /**
     * @param array $value
     *
     * @return array
     */
    private function setAddress(array $value = [], bool $only_state = false)
    {
        if ( ! empty($value)) {

            $value['state'] = isset($value['state']) ? $value['state'] : 'Croatia';

            if ($only_state) {
                $this->address['state'] = $value['state'];
                //dd($this->address);
            } else {
                $this->address = [
                    'fname' => $value['fname'],
                    'lname' => $value['lname'],
                    'email' => $value['email'],
                    'phone' => $value['phone'],
                    'address' => $value['address'],
                    'city' => $value['city'],
                    'zip' => $value['zip'],
                    'state' => $value['state'],
                ];
            }
        } else {
            if (auth()->user()) {
                $this->address = [
                    'fname' => auth()->user()->details->fname,
                    'lname' => auth()->user()->details->lname,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->details->phone,
                    'address' => auth()->user()->details->address,
                    'city' => auth()->user()->details->city,
                    'zip' => auth()->user()->details->zip,
                    'state' => ''
                ];
            }
        }

        CheckoutSession::setAddress($this->address);

        /*CheckoutSession::setGeoZone(
            GeoZone::findState($this->address['state'])
        );*/

        //dd($this->address);

        return $this->address;
    }
}
