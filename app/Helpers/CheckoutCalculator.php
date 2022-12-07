<?php

namespace App\Helpers;

use App\Models\Front\Checkout\Checkout;

/**
 *
 */
class CheckoutCalculator
{

    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * @var
     */
    private $apartment;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var int
     */
    private $total_amount = 0;

    /**
     * @var array
     */
    private $totals = [];


    /**
     * @param Checkout $checkout
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout  = $checkout;
        $this->apartment = $checkout->apartment;
    }


    /**
     * @return array
     */
    public function payableItems()
    {
        if ($this->checkout->regular_days) {
            $this->items[] = $this->regularDays();
        }

        if ($this->checkout->action_regular_days) {
            $this->items[] = $this->actionRegularDays();
        }

        if ($this->checkout->weekends) {
            $this->items[] = $this->weekends();
        }

        if ($this->checkout->action_weekends) {
            $this->items[] = $this->actionWeekends();
        }

        if ($this->checkout->additional_persons) {
            $this->items[] = $this->additionalPersons();
        }

        if ( ! empty($this->checkout->added_options)) {
            foreach ($this->checkout->added_options as $added_option) {
                $this->items[] = $this->additionalOptions($added_option);
            }

        }

        return $this->items;
    }


    /**
     * @return array
     */
    public function totals()
    {
        $subtotal = $this->total_amount / 1.25;
        $tax      = $this->total_amount - $subtotal;

        $this->totals[] = [
            'code'       => 'subtotal',
            'title'      => 'Subtotal',
            'total'      => $subtotal,
            'total_text' => CurrencyHelper::getCurrencyText($subtotal, $this->checkout->main_currency),
        ];

        $this->totals[] = [
            'code'       => 'tax',
            'title'      => 'Tax',
            'total'      => $tax,
            'total_text' => CurrencyHelper::getCurrencyText($tax, $this->checkout->main_currency),
        ];

        $this->totals[] = [
            'code'       => 'total',
            'title'      => 'Total',
            'total'      => $this->total_amount,
            'total_text' => CurrencyHelper::getCurrencyText($this->total_amount, $this->checkout->main_currency),
        ];

        return $this->totals;
    }


    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }


    /**
     * @return array
     */
    private function regularDays()
    {
        $this->total_amount += $this->checkout->regular_days * $this->apartment->price_regular;

        return [
            'id'         => 0,
            'code'       => 'regular_days',
            'title'      => 'Regular days',
            'count'      => $this->checkout->regular_days,
            'price'      => $this->apartment->price_regular,
            'price_text' => CurrencyHelper::getCurrencyText($this->apartment->price_regular, $this->checkout->main_currency),
            'total'      => $this->checkout->regular_days * $this->apartment->price_regular,
            'total_text' => CurrencyHelper::getCurrencyText($this->checkout->regular_days * $this->apartment->price_regular, $this->checkout->main_currency),
        ];
    }


    /**
     * @return array
     */
    private function actionRegularDays()
    {
        $price = $this->apartment->price_regular;
        $action = collect($this->checkout->actions)->first();

        if ($action['action']['type'] == 'F') {
            $price = intval($action['action']['price_regular']);
        }

        $this->total_amount += $this->checkout->action_regular_days * $price;

        return [
            'id'         => 0,
            'code'       => 'action_regular_days',
            'title'      => 'Regular days on Special price',
            'count'      => $this->checkout->action_regular_days,
            'price'      => $price,
            'price_text' => CurrencyHelper::getCurrencyText($price, $this->checkout->main_currency),
            'total'      => $this->checkout->action_regular_days * $price,
            'total_text' => CurrencyHelper::getCurrencyText($this->checkout->action_regular_days * $price, $this->checkout->main_currency),
        ];
    }


    /**
     * @return array
     */
    private function weekends()
    {
        $this->total_amount += $this->checkout->weekends * $this->apartment->price_weekends;

        return [
            'id'         => 0,
            'code'       => 'weekends',
            'title'      => 'Weekends',
            'count'      => $this->checkout->weekends,
            'price'      => $this->apartment->price_weekends,
            'price_text' => CurrencyHelper::getCurrencyText($this->apartment->price_weekends, $this->checkout->main_currency),
            'total'      => $this->checkout->weekends * $this->apartment->price_weekends,
            'total_text' => CurrencyHelper::getCurrencyText($this->checkout->weekends * $this->apartment->price_weekends, $this->checkout->main_currency),
        ];
    }


    /**
     * @return array
     */
    private function actionWeekends()
    {
        $price = $this->apartment->price_weekends;
        $action = collect($this->checkout->actions)->first();

        if ($action['action']['type'] == 'F') {
            $price = intval($action['action']['price_weekends']);
        }

        $this->total_amount += $this->checkout->action_weekends * $price;

        return [
            'id'         => 0,
            'code'       => 'action_weekends',
            'title'      => 'Weekends on Special price',
            'count'      => $this->checkout->action_weekends,
            'price'      => $price,
            'price_text' => CurrencyHelper::getCurrencyText($price, $this->checkout->main_currency),
            'total'      => $this->checkout->action_weekends * $price,
            'total_text' => CurrencyHelper::getCurrencyText($this->checkout->action_weekends * $price, $this->checkout->main_currency),
        ];
    }


    /**
     * @return array
     */
    private function additionalPersons()
    {
        $person = $this->checkout->additional_person_object;
        $price  = $this->checkout->additional_persons_price;
        $total  = $this->checkout->additional_persons * $this->checkout->additional_persons_price;

        if (isset($person->price_per)) {
            if ($person->price_per == 'day') {
                $price = $this->checkout->additional_persons_price * $this->checkout->total_days;
                $total = ($this->checkout->additional_persons * $this->checkout->total_days) * $this->checkout->additional_persons_price;
            }
        }

        $this->total_amount += $total;

        if (isset($person->price_per)) {
            return [
                'id'         => $person->id,
                'code'       => 'additional_person',
                'title'      => $person->title,
                'count'      => $this->checkout->additional_persons,
                'price'      => $price,
                'price_text' => CurrencyHelper::getCurrencyText($price, $this->checkout->main_currency),
                'total'      => $total,
                'total_text' => CurrencyHelper::getCurrencyText($total, $this->checkout->main_currency),
            ];
        }

        return [];
    }


    /**
     * @param $option
     *
     * @return array
     */
    private function additionalOptions($option)
    {
        $count = 1;

        if ($option['price_per'] == 'day') {
            $count = $this->checkout->total_days;
        }

        $this->total_amount += $option['price'] * $count;

        return [
            'id'         => $option['id'],
            'code'       => 'additional_options',
            'title'      => $option['title'],
            'count'      => $count,
            'price'      => $option['price'],
            'price_text' => CurrencyHelper::getCurrencyText($option['price'], $this->checkout->main_currency),
            'total'      => $option['price'] * $count,
            'total_text' => CurrencyHelper::getCurrencyText($option['price'] * $count, $this->checkout->main_currency),
        ];
    }

}
