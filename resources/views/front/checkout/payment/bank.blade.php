
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

<form name="pay" class="w-100" action="{{ route('naplata') }}" method="GET">


    <div class="d-flex mt-3">
    <div class="w-50 pe-3">
        <a class="btn btn-secondary d-block w-100" href="{{ route('index') }}"><i class="ci-arrow-left  me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a>
    </div>
    <div class="w-50 ps-2">
        <button class="btn btn-primary d-block w-100" type="submit"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Dovrši kupnju</span><i class="ci-arrow-right  ms-1"></i></button>
    </div>

    </div>

</form>
