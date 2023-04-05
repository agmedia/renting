@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="ag-mail-tableset">{!! __('Pozdrav ' . $order->payment_fname) !!}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset"> <h3>Narudžba broj: {{ $order->id }} </h3></td>
        </tr>
        @if ( ! $checkout['is_deposit'])
            <tr>
                <td ><strong>Datum: </strong></td>
                <td>{{ $checkout['request']['dates'] }}</td>
            </tr>
            <tr>
                <td><strong>Broj apartmana</strong></td>
                <td>{{ $order->apartment->title }}</td>
            </tr>
        @endif
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
                    <b>{{ __('Općom uplatnicom / Virmanom / Internet bankarstvom') }}</b>


                @elseif ($order->payment_code == 'cod')
                    <b>{{ __('Gotovinom prilikom pouzeća') }}</b>

                @elseif ($order->payment_code == 'corvus')
                    <b>{{ __('Corvus Pay') }}</b>

                @else
                    <b>{{ __('Plaćanje prilikom preuzimanja') }}</b>

                @endif
                <br><br>

                Lijep pozdrav,<br> SelfCheckIns
            </td>
        </tr>

    </table>
@endsection
