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

    //
    public $from;

    //
    public $to;

    //
    public $total_days = 0;

    //
    public $regular_days = 0;

    //
    public $weekends = 0;

    //
    public $fridays;

    //
    public $saturdays;

    //
    public $adults = 0;

    //
    public $children = 0;

    //
    public $additional_adults = 0;

    //
    public $additional_children = 0;

    //
    public $additional_persons = 0;

    //
    public $additional_persons_price = 0.00;

    //
    public $additional_person_object;

    //
    public $apartment;

    //
    public $main_currency;

    //
    private $request;


    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->main_currency = CurrencyHelper::mainSession();

        $this->resolveDays()
             ->checkAdditionalPersons();
    }


    /**
     * @return $this
     * @throws \Exception
     */
    public function resolveDays()
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
    public function checkAdditionalPersons()
    {
        $this->apartment = Apartment::find($this->request->input('apartment_id'));
        $this->adults    = intval($this->request->input('adults')) ?: 0;
        $this->children  = intval($this->request->input('children')) ?: 0;

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


    public function checkSelectableOptions() {}


    public function getTotal()
    {
        $total = [];
        $items = [];

        $items[] = [
            'code' => 'regular_days',
            'title' => 'Regular days',
            'count' => $this->regular_days,
            'amount' => $this->apartment->price_regular * $this->main_currency->value,
            'total' => ($this->regular_days * $this->apartment->price_regular) * $this->main_currency->value,
        ];

        $items[] = [
            'code' => 'weekends',
            'title' => 'Weekends',
            'count' => $this->weekends,
            'amount' => $this->apartment->price_weekends * $this->main_currency->value,
            'total' => ($this->weekends * $this->apartment->price_weekends) * $this->main_currency->value,
        ];

        if ($this->additional_persons) {
            $items[] = [
                'code' => 'additional_person',
                'title' => $this->additional_person_object->first()->title,
                'count' => $this->additional_persons,
                'amount' => $this->additional_persons * $this->additional_persons_price,
                'total' => ($this->additional_persons * $this->additional_persons_price) * $this->main_currency->value,
            ];

            $total_sum = ($this->regular_days * $this->apartment->price_regular) + ($this->weekends * $this->apartment->price_weekends) + ($this->additional_persons * $this->additional_persons_price);
        } else{
            $total_sum = ($this->regular_days * $this->apartment->price_regular) + ($this->weekends * $this->apartment->price_weekends);
        }


        $subtotal = $total_sum / 1.25;
        $tax = $total_sum - $subtotal;

        $total[] = [
            'code' => 'subtotal',
            'title' => 'Subtotal',
            'total' => $subtotal * $this->main_currency->value,
        ];

        $total[] = [
            'code' => 'tax',
            'title' => 'Tax',
            'total' => $tax * $this->main_currency->value,
        ];

        $total[] = [
            'code' => 'total',
            'title' => 'Total',
            'total' => $total_sum * $this->main_currency->value,
        ];

        return [
            'items' => $items,
            'total' => $total
        ];
    }
}
