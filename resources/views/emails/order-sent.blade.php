@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="ag-mail-tableset">{!! __('Pozdrav ' . $order->payment_fname) !!}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.order-details', ['order' => $order])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                @include('emails.layouts.partials.order-price-table', ['order' => $order])
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                {{ __('Način plaćanja') }}:
                @if ($order->payment_code == 'bank')
                    <b>{{ __('Općom uplatnicom / Virmanom / Internet bankarstvo') }}</b>
                @elseif ($order->payment_code == 'payway')
                    <b>{{ __('T-Com Payway') }}</b>
                @elseif ($order->payment_cod == 'cod')
                    <b>{{ __('mail.card') }}</b>
                @else
                    <b>{{ __('mail.paypal') }}</b>
                @endif
                <br><br>
                Lijep pozdrav,<br>Antikvarijat Biblos
            </td>
        </tr>

    </table>
@endsection
