<h3>{{ __('mail.details.title') }}:</h3>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td style="width: 40%">{{ __('mail.details.name') }}:</td>
        <td style="width: 60%"><b>{{ $order->payment_fname . ' ' . $order->payment_lname }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.address') }}:</td>
        <td><b>{{ $order->payment_address }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.city') }}:</td>
        <td><b>{{ $order->payment_zip . ' ' . $order->payment_city }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.email') }}:</td>
        <td><b>{{ $order->payment_email }}</b></td>
    </tr>
    <tr>
        <td>{{ __('mail.details.phone') }}:</td>
        <td><b>{{ ($order->payment_phone) ? $order->payment_phone : '' }}</b></td>
    </tr>
    @if( ! empty($order->company) || ! empty($order->oib))
        <tr><td></td><td></td></tr>
        <tr>
            <td>{{ __('mail.details.company') }}:</td>
            <td><b>{{ ($order->company) ? $order->company : '' }}</b></td>
        </tr>
        <tr>
            <td>{{ __('mail.details.oib') }}:</td>
            <td><b>{{ ($order->oib) ? $order->oib : '' }}</b></td>
        </tr>
    @endif
</table>
