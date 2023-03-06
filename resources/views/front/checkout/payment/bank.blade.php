<h4 class="text-secondary my-4 mt-4">{{ __('front/checkout.personal_info') }}</h4>
<table class="table table-striped mb-5">
    <tbody>
    <tr>
        <th scope="row">{{ __('front/checkout.name') }}</th>
        <td>{{ $data['firstname'] }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('front/checkout.surname') }}</th>
        <td>{{ $data['lastname'] }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('front/checkout.mobile_number') }}</th>
        <td>{{ $data['telephone'] }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('front/checkout.email_address') }}</th>
        <td>{{ $data['email'] }}</td>
    </tr>
    </tbody>
</table>

<div class="col-sm-12 mt-5 text-center">
    <p>{!!   __('front/success.success_html_text') !!}<br>
        IBAN: HR4723900011101317916<br>
        MODEL: 00 {{ __('front/success.reference_number') }}: {{ $data['order_id'] }}</p>
    <p>{{ __('front/success.scant_text') }}</p>
    <p class="text-center"><img src="{{ asset('media/img/qr/' . $data['image_path']) }}" style="max-width:70%;"></p>
</div>

<form name="pay" class="w-100" action="{{ route('naplata') }}" method="GET">
    <div class="d-flex mt-3">
        <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('index') }}"><i class="ci-arrow-left  me-1"></i><span class="d-none d-sm-inline">{{ __('front/checkout.backbtnpayment') }}</span><span class="d-inline d-sm-none">{{ __('front/checkout.backbtn') }}</span></a></div>
        <div class="w-50 ps-2">
            <button class="btn btn-primary d-block w-100" type="submit"><span class="d-none d-sm-inline">{{ __('front/checkout.finishorder') }}</span><span class="d-inline d-sm-none">{{ __('front/checkout.finishshoping') }}</span><i class="ci-arrow-right ms-1"></i></button>
        </div>
    </div>
</form>
