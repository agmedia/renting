
@extends('front.layouts.app')

@section('content')


<!-- Page Title-->
<div class="page-title-overlap bg-accent pt-4" >
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Adresa isporuke</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Košarica</h1>
        </div>
    </div>
</div>
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <!-- List of items-->
        <section class="col-lg-8">
            <!-- Steps-->


        @include('front.layouts.partials.steps')



        <!-- Shipping address-->
            <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Adresa dostave</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-fn">Ime</label>
                        <input class="form-control" type="text" id="checkout-fn">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-ln">Prezime</label>
                        <input class="form-control" type="text" id="checkout-ln">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-email">E-mail Adresa</label>
                        <input class="form-control" type="email" id="checkout-email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-phone">Telefon</label>
                        <input class="form-control" type="text" id="checkout-phone">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-address">Adresa</label>
                        <input class="form-control" type="text" id="checkout-address">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-city">Grad</label>
                        <input class="form-control" type="text" id="checkout-city">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-zip">Poštanski broj</label>
                        <input class="form-control" type="text" id="checkout-zip">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-country">Država</label>
                        <select class="form-select" id="checkout-country">
                            <option>Odaberite državu</option>
                            <option>Hrvatska</option>
                            <option>Austria</option>
                            <option>...</option>
                        </select>
                    </div>
                </div>

            </div>

            <h6 class="mb-3 py-3 border-bottom">Registracija</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" checked id="same-address">
                <label class="form-check-label" for="same-address">Ujedno napravi i korisnički račun</label>
            </div>
            <!-- Navigation (desktop)-->
            <div class="d-none d-lg-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('kosarica') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na košaricu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('dostava') }}"><span class="d-none d-sm-inline">Na odabir dostave</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>


        </section>
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5 d-none d-lg-block">
            <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
                <div class="py-2 px-xl-2">
                    <div class="widget mb-3">
                        <h2 class="widget-title text-center">Sažetak narudžbe</h2>
                        <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0" href="{{ route('knjiga') }}"><img src="media/img/knjiga-detalj-thumb.jpg" width="64" alt="Product"></a>
                            <div class="ps-2">
                                <h6 class="widget-product-title"><a href="{{ route('knjiga') }}">Martin Cruz Smith: Vukovi jedu pse</a></h6>
                                <div class="widget-product-meta"><span class="text-accent me-2">100.<small>00kn</small></span><span class="text-muted">x 1</span></div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled fs-sm pb-2 border-bottom">
                        <li class="d-flex justify-content-between align-items-center"><span class="me-2">Ukupno:</span><span class="text-end">100.<small>00kn</small></span></li>
                        <li class="d-flex justify-content-between align-items-center"><span class="me-2">Dostava:</span><span class="text-end">25.<small>00kn</small></span></li>


                    </ul>
                    <h3 class="fw-normal text-center my-4">125.<small>00kn</small></h3>

                </div>
            </div>
        </aside>
    </div>
    <!-- Navigation (mobile)-->
    <div class="row d-lg-none">
        <div class="col-lg-8">
            <div class="d-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('kosarica') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na košaricu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('dostava') }}"><span class="d-none d-sm-inline">Na odabir dostave</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
        </div>
    </div>
</div>

@endsection
