<?php

namespace App\Models\Front\Checkout;

use App\Helpers\CurrencyHelper;
use App\Helpers\Helper;
use App\Models\Back\Settings\Settings;
use App\Models\Front\Apartment\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class Checkout
 * @package App\Models\Front\Checkout
 */
class Checkout
{

    public $from;

    public $to;

    public $total_days = 0;

    public $regular_days = 0;

    public $weekends = 0;

    public $fridays;

    public $saturdays;

    public $adults = 0;

    public $children = 0;

    public $additional_adults = 0;

    public $additional_children = 0;

    public $additional_persons = 0;

    public $additional_persons_price = 0.00;

    public $additional_person_object;

    public $total = [];

    public $total_amount = 0;

    public $apartment;

    public $firstname = '';

    public $lastname = '';

    public $phone = '';

    public $email = '';

    public $main_currency;

    public $payments_list;

    public $payment;

    private $request;


    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request       = $request;
        $this->main_currency = CurrencyHelper::mainSession();

        $this->resolveDays()
             ->checkAdditionalPersons()
             ->getPaymentMethodsList();

        $this->total = $this->getTotal();

        if (isset($this->request->firstname) && $this->request->firstname != '') {
            $this->setAddress();
        }
    }


    /**
     * @param string $state
     *
     * @return Collection
     */
    private function getPaymentMethodsList(string $state = 'Croatia')
    {
        $geo = (new GeoZone())->findState($state);

        $this->payments_list = (new PaymentMethod())->findGeo($geo->id)->resolve();

        if ($this->payments_list && (isset($this->request->payment_type) && $this->request->payment_type != '')) {
            $this->setPayment($this->request->payment_type);
        }

        return $this;
    }


    /**
     * @return $this
     * @throws \Exception
     */
    private function resolveDays()
    {
        $dates = explode(' - ', $this->request->input('dates'));

        $this->from         = Carbon::make($dates[0]);
        $this->to           = Carbon::make($dates[1]);
        $this->total_days   = $this->from->diffInDays($this->to);
        $this->fridays      = Helper::getDaysInRange($dates[0], $dates[1], 'friday');
        $this->saturdays    = Helper::getDaysInRange($dates[0], $dates[1], 'saturday');
        $this->regular_days = $this->total_days - count($this->fridays) - count($this->saturdays);
        $this->weekends     = $this->total_days - $this->regular_days;

        return $this;
    }


    /**
     * @return $this
     */
    private function checkAdditionalPersons()
    {
        $this->apartment = Apartment::find($this->request->input('apartment_id'));
        $this->adults    = intval($this->request->input('adults')) ?: $this->apartment->adults;
        $this->children  = intval($this->request->input('children')) ?: $this->apartment->children;

        $this->additional_person_object = $this->apartment->options()->where('reference', 'person')->get();

        if ($this->additional_person_object->count()) {
            if ($this->adults > $this->apartment->adults) {
                $this->additional_adults = $this->adults - $this->apartment->adults;
            }

            if ($this->children > $this->apartment->children) {
                $this->additional_children = $this->children - $this->apartment->children;
            }

            $this->additional_persons       = $this->additional_adults + $this->additional_children;
            $this->additional_persons_price = $this->additional_person_object->first()->price * $this->main_currency->value;
        }

        return $this;
    }


    public function checkSelectableOptions()
    {
    }


    /**
     * @return array[]
     */
    public function getTotal(): array
    {
        $total = [];
        $items = [];

        $items[] = [
            'code'   => 'regular_days',
            'title'  => 'Regular days',
            'count'  => $this->regular_days,
            'amount' => $this->apartment->price_regular * $this->main_currency->value,
            'total'  => ($this->regular_days * $this->apartment->price_regular) * $this->main_currency->value,
        ];

        $items[] = [
            'code'   => 'weekends',
            'title'  => 'Weekends',
            'count'  => $this->weekends,
            'amount' => $this->apartment->price_weekends * $this->main_currency->value,
            'total'  => ($this->weekends * $this->apartment->price_weekends) * $this->main_currency->value,
        ];

        if ($this->additional_persons) {
            $items[] = [
                'code'   => 'additional_person',
                'title'  => $this->additional_person_object->first()->title,
                'count'  => $this->additional_persons,
                'amount' => $this->additional_persons * $this->additional_persons_price,
                'total'  => ($this->additional_persons * $this->additional_persons_price) * $this->main_currency->value,
            ];

            $total_sum = ($this->regular_days * $this->apartment->price_regular) + ($this->weekends * $this->apartment->price_weekends) + ($this->additional_persons * $this->additional_persons_price);
        } else {
            $total_sum = ($this->regular_days * $this->apartment->price_regular) + ($this->weekends * $this->apartment->price_weekends);
        }

        $subtotal = $total_sum / 1.25;
        $tax      = $total_sum - $subtotal;

        $total[] = [
            'code'  => 'subtotal',
            'title' => 'Subtotal',
            'total' => $subtotal * $this->main_currency->value,
        ];

        $total[] = [
            'code'  => 'tax',
            'title' => 'Tax',
            'total' => $tax * $this->main_currency->value,
        ];

        $total[] = [
            'code'  => 'total',
            'title' => 'Total',
            'total' => $total_sum * $this->main_currency->value,
        ];

        $this->total_amount = $total_sum * $this->main_currency->value;

        return [
            'items' => $items,
            'total' => $total
        ];
    }


    /**
     * @param $address
     *
     * @return array
     */
    public function setAddress($address = null): array
    {
        if ($address) {
            $this->firstname = $address['firstname'];
            $this->lastname = $address['lastname'];
            $this->phone = $address['phone'];
            $this->email = $address['email'];
        } else {
            $this->firstname = $this->request->input('firstname');
            $this->lastname = $this->request->input('lastname');
            $this->phone = $this->request->input('phone');
            $this->email = $this->request->input('email');
        }

        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }


    public function setPayment(string $payment = null)
    {
        if ($payment) {
            $this->payment = $this->payments_list->where('code', $payment)->first();
        } else {
            $this->payment = $this->payments_list->where('code', $this->request->payment_type)->first();
        }

        //dd($this->payment);

        return $this->payment->code ?: null;
    }

}
