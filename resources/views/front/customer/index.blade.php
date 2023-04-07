@extends('front.layouts.app')

@section('content')

    @include('front.customer.layouts.header')

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
        @include('front.customer.layouts.sidebar')
        <!-- Content  -->
            <section class="col-lg-8">
                @include('front.customer.layouts.title', ['title' => __('front/common.acc_edit')])

                @include('front.layouts.partials.session')
                <form action="{{ route('moj-racun.snimi', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}

                    <div class="row ">
                        <div class="col-sm-12">
                            <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">{{ __('front/common.acc_basic') }}</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="checkout-fn">{{ __('front/common.name') }}</label>
                                <input class="form-control @error('fname') is-invalid @enderror" type="text" name="fname" value="{{ $user->details->fname }}">
                                @error('fname') <div id="val-username-error" class="invalid-feedback animated fadeIn">{{ __('front/common.name_error') }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="checkout-ln">{{ __('front/common.lname') }}</label>
                                <input class="form-control @error('lname') is-invalid @enderror" type="text" name="lname" value="{{ $user->details->lname }}">
                                @error('lname') <div id="val-username-error" class="invalid-feedback animated fadeIn">{{ __('front/common.lname_error') }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="checkout-email">{{ __('front/common.email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" readonly name="email" value="{{ $user->email }}">
                                @error('email') <div id="val-username-error" class="invalid-feedback animated fadeIn">{{ __('front/common.email_error') }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="checkout-phone">{{ __('front/common.mobile') }}</label>
                                <input class="form-control" type="text" name="phone" value="{{ $user->details->phone }}">
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary d-block w-100">{{ __('front/common.save') }}</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    </div>

@endsection
