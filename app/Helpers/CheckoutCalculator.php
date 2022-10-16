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
     * @var \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    private $currency;

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
        $this->currency  = $checkout->main_currency;
    }


    /**
     * @return array
     */
    public function payableItems()
    {
        if ($this->checkout->regular_days) {
            $this->items[] = $this->regularDays();
        }

        if ($this->checkout->weekends) {
            $this->items[] = $this->weekends();
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
            'total_text' => $this->currencyValue($subtotal),
        ];

        $this->totals[] = [
            'code'       => 'tax',
            'title'      => 'Tax',
            'total'      => $tax,
            'total_text' => $this->currencyValue($tax),
        ];

        $this->totals[] = [
            'code'       => 'total',
            'title'      => 'Total',
            'total'      => $this->total_amount,
            'total_text' => $this->currencyValue($this->total_amount),
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
            'price_text' => $this->currencyValue($this->apartment->price_regular),
            'total'      => $this->checkout->regular_days * $this->apartment->price_regular,
            'total_text' => $this->currencyValue($this->checkout->regular_days * $this->apartment->price_regular),
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
            'price_text' => $this->currencyValue($this->apartment->price_weekends),
            'total'      => $this->checkout->weekends * $this->apartment->price_weekends,
            'total_text' => $this->currencyValue($this->checkout->weekends * $this->apartment->price_weekends),
        ];
    }


    /**
     * @return array
     */
    private function additionalPersons()
    {
        $person = $this->checkout->additional_person_object->first();
        $price  = $this->checkout->additional_persons_price;
        $total  = $this->checkout->additional_persons * $this->checkout->additional_persons_price;

        if ($person->price_per == 'day') {
            $price = $this->checkout->additional_persons_price * $this->checkout->total_days;
            $total = ($this->checkout->additional_persons * $this->checkout->total_days) * $this->checkout->additional_persons_price;
        }

        $this->total_amount += $total;

        return [
            'id'         => $person->id,
            'code'       => 'additional_person',
            'title'      => $person->title,
            'count'      => $this->checkout->additional_persons,
            'price'      => $price,
            'price_text' => $this->currencyValue($price),
            'total'      => $total,
            'total_text' => $this->currencyValue($total),
        ];
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
            'price_text' => $this->currencyValue($option['price']),
            'total'      => $option['price'] * $count,
            'total_text' => $this->currencyValue($option['price'] * $count),
        ];
    }


    /**
     * @param $price
     *
     * @return float|int
     */
    private function currencyValue($price)
    {
        $left  = $this->currency->symbol_left ? $this->currency->symbol_left . ' ' : '';
        $right = $this->currency->symbol_right ? ' ' . $this->currency->symbol_right : '';

        return $left . number_format(($price * $this->currency->value), $this->currency->decimal_places, ',', '.') . $right;
    }

}
