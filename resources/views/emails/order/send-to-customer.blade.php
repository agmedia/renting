@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="ag-mail-tableset">{!! __('Pozdrav ' . $order->payment_fname) !!}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset"> <h3>Narudžba broj: {{ $order->id }} </h3></td>
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
                    <b>{{ __('Općom uplatnicom / Virmanom / Internet bankarstvom') }}</b>

                    <p>{{ __('front/success.success_text') }} {{ $order->id }} .</p>
                    {!!   __('front/success.success_html_text') !!}
                    <p>{{ __('front/success.payment_text') }}  {{ $order->total_text }}<br>
                        IBAN: HR4723900011101317916<br>
                        MODEL: 00 {{ __('front/success.reference_number') }}: {{ $order->id }}-{{date('ym')}}</p>
                    <p>{{ __('front/success.scant_text') }}</p>
                    <p class="text-center"><img src="{{ asset('media/img/qr/'.$order->id) }}.png" style="max-width:320px"></p>

                @elseif ($order->payment_code == 'cod')
                    <b>{{ __('Gotovinom prilikom pouzeća') }}</b>
                    <p style="font-size:12px">Uredno smo zaprimili Vašu narudžbu broj {{ $order->id }} i zahvaljujemo Vam.</p>
                @elseif ($order->payment_code == 'corvus')
                    <b>{{ __('Corvus Pay') }}</b>
                    <p style="font-size:12px">Uredno smo zaprimili Vašu narudžbu broj {{ $order->id }} i zahvaljujemo Vam.</p>
                @else
                    <b>{{ __('Plaćanje prilikom preuzimanja') }}</b>
                    <p style="font-size:12px">Uredno smo zaprimili Vašu narudžbu broj {{ $order->id }} i zahvaljujemo Vam.</p>
                @endif
                <br><br>

                Lijep pozdrav,<br> SelfCheckIns
            </td>
        </tr>

    </table>
@endsection
