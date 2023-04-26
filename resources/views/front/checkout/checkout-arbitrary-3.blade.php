@extends('front.layouts.app')

@push('css_after')
    <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.0/dist/index.umd.min.js"></script>
@endpush

@section('content')

    <div class="page-banner full-row bg-white py-5">
        <div class="container">
            <div class="row row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <h3 class="page-name text-secondary m-0"> <a href="{{ route('index') }}"><i class="fas fa-angle-left me-5"></i></a>{{ __('front/checkout.special') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-white pt-0">
        <div class="container">
            <div class="row">
                <form action="{{ route('checkout.arbitrary.pay') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="col-lg-12 order-lg-1 mt-0">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-secondary my-4 mt-4">{{ __('front/checkout.personal_info') }}</h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" id="firstname" name="firstname" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.name') }}" value="" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" id="lastname" name="lastname" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.surname') }}" value="" required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" id="mobile" name="mobile" class="form-control bg-gray" placeholder="{{ __('front/checkout.mobile_number') }}" value="" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" id="email" name="email" class="form-control bg-gray" placeholder="{{ __('front/checkout.email_address') }}" value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="text-secondary my-4 mt-4">{{ __('front/checkout.arbitrary.price') }}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group flex-nowrap select-arrow">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-shopping-cart"></i></span>
                                            <select class="form-control bg-gray form-select" id="select-scope" name="scope_id">
                                                <option value="0" selected>{{ __('front/checkout.arbitrary.select_scope') }}</option>
                                                @foreach (config('settings.deposit_scopes') as $scope_id => $scope)
                                                    <option value="{{ $scope_id }}">{{ $scope['title'][current_locale()] }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('scope'))
                                                <span class="ml-2 font-size-sm text-danger">{{ __('front/checkout.arbitrary.scope_error') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="amount" class="form-control bg-gray mb-3" placeholder="{{ __('front/checkout.arbitrary.amount') }}" value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="text-secondary my-4 mt-4">{{ __('front/checkout.additional_comments') }}</h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <textarea id="comment" name="comment" class="form-control bg-gray mb-3" rows="5" placeholder="{{ __('front/checkout.type_comments') }}"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary" role="alert">
                                            {!! __('front/checkout.agree') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save" aria-hidden="true"></i> {{ __('front/checkout.confirm_and_pay') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
