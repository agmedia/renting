<?php

namespace App\Http\Livewire\Front;

use App\Helpers\Session\CheckoutSession;
use App\Models\Back\Settings\Settings;
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
        'country' => '',
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
        if (CheckoutSession::hasAddress()) {
            $this->setAddress(CheckoutSession::getAddress());
        } else {
            $this->setAddress();
        }

        if (CheckoutSession::hasShipping()) {
            $this->shipping = CheckoutSession::getShipping();
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
     * @param string $shipping
     */
    public function selectShipping(string $shipping)
    {
        $this->shipping = $shipping;

        CheckoutSession::setShipping($shipping);
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
        return view('livewire.front.checkout', [
            'shippingMethods' => Settings::getList('shipping'),
            'paymentMethods' => Settings::getList('payment')
        ]);
    }


    /**
     * @param array $value
     *
     * @return array
     */
    private function setAddress(array $value = [])
    {
        if ( ! empty($value)) {
            return
                $this->address = [
                    'fname' => $value['fname'],
                    'lname' => $value['lname'],
                    'email' => $value['email'],
                    'phone' => $value['phone'],
                    'address' => $value['address'],
                    'city' => $value['city'],
                    'zip' => $value['zip'],
                ];
        }

        if (auth()->user()) {
            $this->address = [
                'fname' => auth()->user()->details->fname,
                'lname' => auth()->user()->details->lname,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->details->phone,
                'address' => auth()->user()->details->address,
                'city' => auth()->user()->details->city,
                'zip' => auth()->user()->details->zip,
            ];

            CheckoutSession::setAddress($this->address);
        }
    }
}
