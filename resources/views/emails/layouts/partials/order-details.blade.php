<h3>{{ __('Detalji narudžbe') }}:</h3>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td style="width: 40%">{{ __('Ime i prezime') }}:</td>
        <td style="width: 60%"><b>{{ $order->payment_fname . ' ' . $order->payment_lname }}</b></td>
    </tr>
    <tr>
        <td>{{ __('Email adresa') }}:</td>
        <td><b>{{ $order->payment_email }}</b></td>
    </tr>
    <tr>
        <td>{{ __('Telefon') }}:</td>
        <td><b>{{ ($order->payment_phone) ? $order->payment_phone : '' }}</b></td>
    </tr>

</table>
