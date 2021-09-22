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
                    <b>{{ __('Općom uplatnicom / Virmanom / Internet bankarstvom') }}</b>

                    <p>Uredno smo zaprimili Vašu narudžbu broj {{ $order->id }} i zahvaljujemo Vam.</p><p>Molimo vas da izvršite uplatu po sljedećim uputama za plaćanje.</p>

                    <p> Rok za uplatu je maksimalno 48h tijekom koga robu koju ste naručili držimo rezerviranu za vas.</p>

                    <p> Ukoliko u tom roku ne zaprimimo uplatu, nažalost moramo poništiti ovu narudžbu.</p>

                    <p>MOLIMO IZVRŠITE UPLATU U IZNOSU OD  {{number_format($order->total, 2)}} kn<br>


                        IBAN RAČUN: HR3123600001101595832<br>
                        MODEL: 00 POZIV NA BROJ: {{ $order->total }}-{{date('ym')}}</p>


                    <p>ILI JEDNOSTAVNO POSKENIRAJTE 2D BARKOD</p>

                    <p><img src="{{ asset('media/img/qr/'.$order->id) }}.png" ></p>

                @elseif ($order->payment_code == 'cod')
                    <b>{{ __('Gotovinom prilikom pouzeća') }}</b>
                @elseif ($order->payment_code == 'payway')
                    <b>{{ __('T-Com Payway') }}</b>
                @else
                    <b>{{ __('Plaćanje prilikom preuzimanja') }}</b>
                @endif
                <br><br>

                Lijep pozdrav,<br>Antikvarijat Biblos
            </td>
        </tr>

    </table>
@endsection
