
@extends('front.layouts.app')

@section('content')

<div class="page-title-overlap bg-accent pt-4" >
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Potvrdite narudžbu</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Način plaćanja</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <section class="col-lg-8">

            <div class="steps steps-light pt-2 pb-3 mb-5">
                <a class="step-item active" href="{{ route('kosarica') }}">
                    <div class="step-progress"><span class="step-count">1</span></div>
                    <div class="step-label"><i class="ci-cart"></i>Košarica</div>
                </a>
                <a class="step-item active" href="{{ route('naplata', ['step' => 'podaci']) }}">
                    <div class="step-progress"><span class="step-count">2</span></div>
                    <div class="step-label"><i class="ci-user-circle"></i>Podaci</div>
                </a>
                <a class="step-item active" href="{{ route('naplata', ['step' => 'dostava']) }}">
                    <div class="step-progress"><span class="step-count">3</span></div>
                    <div class="step-label"><i class="ci-package"></i>Dostava</div>
                </a>
                <a class="step-item active" href="{{ route('naplata', ['step' => 'placanje']) }}">
                    <div class="step-progress"><span class="step-count">4</span></div>
                    <div class="step-label"><i class="ci-card"></i>Plaćanje</div>
                </a>
                <a class="step-item current active" href="{{ route('pregled') }}">
                    <div class="step-progress"><span class="step-count">5</span></div>
                    <div class="step-label"><i class="ci-check-circle"></i>Pregledaj</div>
                </a>
            </div>

            <h2 class="h6 pt-1 pb-3 mb-3">Pregled košarice</h2>
            <cart-view continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}" buttons="false"></cart-view>

            <div class="bg-secondary rounded-3 px-4 pt-4 pb-2">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="h6">Platitelj:</h4>
                        <ul class="list-unstyled fs-sm">
                            @if (auth()->guest())
                                <li><span class="text-muted">Korisnik:&nbsp;</span>{{ $data['address']['fname'] }} {{ $data['address']['lname'] }}</li>
                                <li><span class="text-muted">Adresa:&nbsp;</span>{{ $data['address']['address'] }}, {{ $data['address']['zip'] }} {{ $data['address']['city'] }}, Hrvatska</li>
                                <li><span class="text-muted">Email:&nbsp;</span>{{ $data['address']['email'] }}</li>
                            @else
                                <li><span class="text-muted">Korisnik:&nbsp;</span>{{ auth()->user()->details->fname }} {{ auth()->user()->details->lname }}</li>
                                <li><span class="text-muted">Adresa:&nbsp;</span>{{ auth()->user()->details->address }}, {{ auth()->user()->details->zip }} {{ auth()->user()->details->city }}, Hrvatska</li>
                                <li><span class="text-muted">Email:&nbsp;</span>{{ auth()->user()->email }}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="h6">Dostaviti na:</h4>
                        <ul class="list-unstyled fs-sm">
                            <li><span class="text-muted">Korisnik:&nbsp;</span>{{ $data['address']['fname'] }} {{ $data['address']['lname'] }}</li>
                            <li><span class="text-muted">Adresa:&nbsp;</span>{{ $data['address']['address'] }}, {{ $data['address']['zip'] }} {{ $data['address']['city'] }}, Hrvatska</li>
                            <li><span class="text-muted">Email:&nbsp;</span>{{ $data['address']['email'] }}</li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="h6">Način dostave:</h4>
                        <ul class="list-unstyled fs-sm">
                            <li>
                                <span class="text-muted">{{ $shipping->title }} </span><br>
                                {{ $shipping->data->description ?: $shipping->data->short_description }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="h6">Način plaćanja:</h4>
                        <ul class="list-unstyled fs-sm">
                            <li>
                                <span class="text-muted">{{ $payment->title }} </span><br>
                                {{ $payment->data->description ?: $payment->data->short_description }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('naplata') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('success') }}"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>

        </section>

        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5 d-none d-lg-block">
            <cart-view-aside route="pregled" continueurl="{{ route('index') }}" checkouturl="{{ route('naplata') }}"></cart-view-aside>
        </aside>
    </div>

    <div class="row d-lg-none">
        <div class="col-lg-8">
            <div class="d-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('naplata') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('success') }}"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
        </div>
    </div>
</div>

@endsection
