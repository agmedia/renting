<?php

namespace App\Models\Front\Checkout;

use App\Helpers\ActionHelper;
use App\Helpers\CheckoutCalculator;
use App\Helpers\Helper;
use App\Models\Front\Apartment\Apartment;
use App\Models\Front\Catalog\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class Checkout
 * @package App\Models\Front\Checkout
 */
class Checkout
{

    // Days

    public $from;

    public $to;

    public $days = [];

    public $total_days = 0;

    public $regular_days = 0;

    public $weekends = 0;

    public $action_regular_days = 0;

    public $action_weekends = 0;

    public $fridays = [];

    public $saturdays = [];

    // Persons

    public $adults = 0;

    public $children = 0;

    public $babies = 0;

    public $additional_persons = 0;

    public $additional_persons_price = 0.00;

    public $additional_person_object = null;

    public $firstname = '';

    public $lastname = '';

    public $phone = '';

    public $email = '';

    // Options & Totals

    public $added_options = [];

    public $actions = [];

    public $force_paid_amount = null;

    public $paid_amount_percentage = 0;

    public $total = [];

    public $total_amount = 0;

    public $apartment;

    public $main_currency;

    public $payments_list;

    public $payment;

    public $request;


    /**
     * @param Request $request
     *                        ['apartment_id', 'dates', 'firstname', 'lastname', 'email', 'phone']
     */
    public function __construct(Request $request)
    {
        $this->request       = $request;
        $this->main_currency = ag_currencies(true);
        $this->apartment     = $this->getApartment($this->request->input('apartment_id'));

        $this->resolveDays()
             ->resolveActions()
             ->checkAdditionalPersons()
             ->checkAutoInsertOptions()
             ->checkSelectableOptions()
             ->getPaymentMethodsList();

        $this->total = $this->getTotal();

        $this->isPaidAmountForced();

        if (isset($this->request->firstname) && $this->request->firstname != '') {
            $this->setAddress();
        }
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
            $this->lastname  = $address['lastname'];
            $this->phone     = $address['phone'];
            $this->email     = $address['email'];
        } else {
            $this->firstname = $this->request->input('firstname');
            $this->lastname  = $this->request->input('lastname');
            $this->phone     = $this->request->input('phone');
            $this->email     = $this->request->input('email');
        }

        return [
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'phone'     => $this->phone,
            'email'     => $this->email,
        ];
    }


    /**
     * @param string|null $payment
     *
     * @return null
     */
    public function setPayment(string $payment = null)
    {
        if ($payment) {
            $this->payment = $this->payments_list->where('code', $payment)->first();
        } else {
            $this->payment = $this->payments_list->where('code', $this->request->payment_type)->first();
        }

        if ( ! isset($this->payment->code)) {
            $this->payment = $this->payments_list->where('code', config('settings.payment.default'))->first();
        }

        return $this->payment->code ?: null;
    }


    /**
     * @return array
     */
    public function getOptions()
    {
        $response = [];
        $options  = $this->apartment->options()->withoutPersons()->withoutAutoInsert()->get();

        foreach ($options as $option) {
            $response[$option->id]            = $option->toArray();
            $response[$option->id]['checked'] = 0;

            if ( ! empty($this->added_options)) {
                foreach ($this->added_options as $added_option) {
                    if ($option->id == $added_option['id']) {
                        $response[$option->id]['checked'] = 1;
                    }
                }
            }
        }

        return $response;
    }


    /**
     * @return array
     */
    public function getAutoInsertOptions()
    {
        $response = [];
        $options  = $this->apartment->options()->autoInsertOnly()->get();

        foreach ($options as $option) {
            $response[$option->id]            = $option->toArray();
            $response[$option->id]['checked'] = 0;
        }

        if ($this->additional_persons) {
            $persons = $this->apartment->options()->personOption()->get();

            foreach ($persons as $option) {
                $response[$option->id]            = $option->toArray();
                $response[$option->id]['checked'] = 0;
            }
        }

        return $response;
    }


    /**
     * @return array
     */
    public function cleanData(): array
    {
        return [
            'total_days'               => $this->total_days,
            'regular_days'             => $this->regular_days,
            'weekends'                 => $this->weekends,
            'fridays'                  => $this->fridays,
            'saturdays'                => $this->saturdays,
            'adults'                   => $this->adults,
            'children'                 => $this->children,
            'babies'                   => $this->babies,
            'additional_persons'       => $this->additional_persons,
            'additional_persons_price' => $this->additional_persons_price,
            'additional_persons_obj'   => $this->additional_person_object,
            'added_options'            => $this->added_options,
            'forced_paid_amount'       => $this->force_paid_amount,
            'paid_percentage'          => $this->paid_amount_percentage,
            'total'                    => $this->total,
            'apartment_id'             => $this->apartment->id ?: 0,
            'main_currency'            => $this->main_currency,
            'payment'                  => $this->payment ?: null,
            'request'                  => $this->request->toArray()
        ];
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @return $this
     */
    private function isPaidAmountForced()
    {
        if ($this->request->has('payment_amount')) {
            // If differance between total and paid amount.
            if ((int) $this->request->input('payment_amount') < (int) $this->total_amount) {
                $this->force_paid_amount      = $this->request->input('payment_amount');
                $this->paid_amount_percentage = Helper::calculateDiscount((float) $this->total_amount, (float) $this->force_paid_amount);
            }
        }

        return $this;
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

        if ($this->payments_list) {
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
        $this->days         = Helper::getDaysInRange($dates[0], $dates[1]);
        $this->total_days   = $this->from->diffInDays($this->to);
        $this->fridays      = Helper::getWeekends($dates[0], $dates[1], 'friday');
        $this->saturdays    = Helper::getWeekends($dates[0], $dates[1], 'saturday');
        $this->regular_days = $this->total_days - count($this->fridays) - count($this->saturdays);
        $this->weekends     = $this->total_days - $this->regular_days;

        return $this;
    }


    /**
     * @return $this
     */
    private function resolveActions()
    {
        $actions = $this->apartment->hasActiveActions($this->from, $this->to, $this->days);

        if ($actions->count()) {
            $weekends = collect($this->fridays)->concat($this->saturdays);

            foreach ($actions as $action) {
                $this->actions[$action->id]                              = ActionHelper::resolveCheckoutData($action, $this->days, $this->apartment);
                $this->actions[$action->id]['weekends'][$action->id]     = $weekends->intersect($this->actions[$action->id]['days'])->toArray();
                $this->actions[$action->id]['regular_days'][$action->id] = collect($this->actions[$action->id]['days'])->diff($this->actions[$action->id]['weekends'][$action->id])->toArray();

                $this->action_regular_days += count($this->actions[$action->id]['regular_days'][$action->id]);
                $this->action_weekends     += count($this->actions[$action->id]['weekends'][$action->id]);
            }

            $this->regular_days = $this->regular_days - $this->action_regular_days;
            $this->weekends     = $this->weekends - $this->action_weekends;
        }

        return $this;
    }


    /**
     * @return $this
     */
    private function checkAdditionalPersons()
    {
        $this->adults   = $this->resolveRegularPerson(intval($this->request->input('adults')), $this->apartment->max_adults, 1);
        $this->children = $this->resolveRegularPerson(intval($this->request->input('children')), $this->apartment->max_children);
        $this->babies   = $this->resolveRegularPerson(intval($this->request->input('baby')), $this->apartment->max_children);

        $this->additional_persons = $this->resolveAdditionalPerson($this->adults + $this->children + $this->babies);

        if ($this->additional_persons) {
            $this->additional_person_object = $this->apartment->options()->where('reference', 'person')->orderBy('price')->first();

            if ($this->additional_person_object) {
                $this->additional_persons_price = $this->additional_person_object->price * $this->main_currency->value;
            }
        }

        return $this;
    }


    /**
     * @param int $count
     * @param int $max
     * @param int $default
     *
     * @return int
     */
    private function resolveRegularPerson(int $count, int $max, int $default = 0)
    {
        $count = $count ?: $default;

        if ($count > $max) {
            $count = $max;
        }

        return $count;
    }


    /**
     * @param int $target
     *
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|int|mixed
     */
    private function resolveAdditionalPerson(int $target)
    {
        $persons = 0;

        if ($target > $this->apartment->regular_persons) {
            $persons = $target - $this->apartment->regular_persons;
        }

        if ($persons > $this->apartment->max_persons) {
            $persons = $target - $this->apartment->max_persons;
        }

        return $persons;
    }


    /**
     * @return $this
     */
    private function checkAutoInsertOptions()
    {
        $options = $this->apartment->options()->withoutPersons()->where('auto_insert', 1)->get();

        if ($options->count()) {
            foreach ($options as $option) {
                array_push($this->added_options, $option->toArray());
            }
        }

        return $this;
    }


    /**
     * @return $this
     */
    private function checkSelectableOptions()
    {
        if (isset($this->request->additional) && is_array($this->request->additional)) {
            foreach ($this->request->additional as $id => $additional) {
                $option = Option::find($id);
                array_push($this->added_options, $option->toArray());
            }
        }

        return $this;
    }


    /**
     * @return array[]
     */
    private function getTotal(): array
    {
        $calc  = new CheckoutCalculator($this);
        $items = $calc->payableItems();
        $total = $calc->totals();

        $this->total_amount = $calc->getTotalAmount();

        return [
            'items' => $items,
            'total' => $total
        ];
    }


    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private function getApartment(int $id = null)
    {
        return Apartment::query()->where('id', $id)->first();
    }

}
