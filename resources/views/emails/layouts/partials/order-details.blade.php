<h3>{{ __('front/common.details') }} :</h3>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td style="width: 40%">{{ __('front/common.name') }}:</td>
        <td style="width: 60%"><b>{{ $order->payment_fname . ' ' . $order->payment_lname }}</b></td>
    </tr>
    <tr>
        <td>{{ __('front/common.email') }}:</td>
        <td><b>{{ $order->payment_email }}</b></td>
    </tr>
    <tr>
        <td>{{ __('front/common.mobile') }}:</td>
        <td><b>{{ ($order->payment_phone) ?: '' }}</b></td>
    </tr>

    @if ($checkout['is_deposit'])
        <tr>
            <td><strong>{{ __('front/checkout.dates') }}</strong></td>
            <td>{{ $order['reservation']['request']['dates'] }}</td>
        </tr>
        <tr>
            <td><strong>{{ __('front/checkout.Guests') }}</strong></td>
            <td>{{ $order['reservation']['request']['adults'] + $order['reservation']['request']['children'] }} {{ __('front/checkout.guests') }}</td>
        </tr>
    @endif

</table>
