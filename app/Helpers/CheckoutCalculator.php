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
        $subtotal = $this->total_amount;
        //$tax      = $this->total_amount - $subtotal;

        $this->totals[] = [
            'code'       => 'subtotal',
            'title'      => __('front/checkout.subtotal'),
            'total'      => currency_main($subtotal),
            'total_text' => currency_main($subtotal, true),
        ];

      /*  $this->totals[] = [
            'code'       => 'tax',
            'title'      => __('front/checkout.tax'),
            'total'      => currency_main($tax),
            'total_text' => currency_main($tax, true),
        ];*/

        $this->totals[] = [
            'code'       => 'total',
            'title'      => __('front/checkout.total'),
            'total'      => currency_main($this->total_amount),
            'total_text' => currency_main($this->total_amount, true),
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
        $total = $this->checkout->regular_days * $this->apartment->price_regular;
        $this->total_amount += $total;

        return [
            'id'         => 0,
            'code'       => 'regular_days',
            'title'      => __('front/checkout.regulardays'),
            'count'      => $this->checkout->regular_days,
            'price'      => currency_main($this->apartment->price_regular),
            'price_text' => currency_main($this->apartment->price_regular, true),
            'total'      => currency_main($total),
            'total_text' => currency_main($total, true),
        ];
    }


    /**
     * @return array
     */
    private function actionRegularDays()
    {
        $price = $this->apartment->price_regular;
        $action = collect($this->checkout->actions)->first();

        if (in_array($action['action']['type'], ['F', 'P'])) {
            $price = floatval($action['action']['price_regular']);
        }

        $total = $this->checkout->action_regular_days * $price;
        $this->total_amount += $total;

        return [
            'id'         => 0,
            'code'       => 'action_regular_days',
            'title'      => __('front/checkout.regulardays') . '<br><span class="text-primary">' . $action['action']['title'] . '</span>',
            'count'      => $this->checkout->action_regular_days,
            'price'      => currency_main($price),
            'price_text' => currency_main($price, true),
            'total'      => currency_main($total),
            'total_text' => currency_main($total, true),
        ];
    }


    /**
     * @return array
     */
    private function weekends()
    {
        $total = $this->checkout->weekends * $this->apartment->price_weekends;
        $this->total_amount += $total;

        return [
            'id'         => 0,
            'code'       => 'weekends',
            'title'      => __('front/checkout.weekends'),
            'count'      => $this->checkout->weekends,
            'price'      => currency_main($this->apartment->price_weekends),
            'price_text' => currency_main($this->apartment->price_weekends, true),
            'total'      => currency_main($total),
            'total_text' => currency_main($total, true),
        ];
    }


    /**
     * @return array
     */
    private function actionWeekends()
    {
        $price = $this->apartment->price_weekends;
        $action = collect($this->checkout->actions)->first();

        if (in_array($action['action']['type'], ['F', 'P'])) {
            $price = floatval($action['action']['price_weekends']);
        }

        $total = $this->checkout->action_weekends * $price;
        $this->total_amount += $total;

        return [
            'id'         => 0,
            'code'       => 'action_weekends',
            'title'      => __('front/checkout.weekends') . '<br><span class="text-primary">' . $action['action']['title'] . '</span>',
            'count'      => $this->checkout->action_weekends,
            'price'      => currency_main($price),
            'price_text' => currency_main($price, true),
            'total'      => currency_main($total),
            'total_text' => currency_main($total, true),
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
                'price'      => currency_main($price),
                'price_text' => currency_main($price, true),
                'total'      => currency_main($total),
                'total_text' => currency_main($total, true),
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

        $total = $option['price'] * $count;
        $this->total_amount += $total;

        return [
            'id'         => $option['id'],
            'code'       => 'additional_options',
            'title'      => $option['title'],
            'count'      => $count,
            'price'      => currency_main($option['price']),
            'price_text' => currency_main($option['price'], true),
            'total'      => currency_main($total),
            'total_text' => currency_main($total, true),
        ];
    }

}
