
@extends('front.layouts.app')

@section('content')


<!-- Page Title-->
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
        <!-- List of items-->
        <section class="col-lg-8">
            <!-- Steps-->


        @include('front.layouts.partials.steps')



        <!-- Shipping address-->
            <h2 class="h6 pt-1 pb-3 mb-3 ">Pregled košarice</h2>

            <!-- Item-->
            <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom">
                <div class="d-block d-sm-flex align-items-center text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('knjiga') }}"><img src="media/img/knjiga-detalj-thumb.jpg" width="120" alt="Martin Cruz Smith: Vukovi jedu pse"></a>
                    <div class="pt-2">
                        <h3 class="product-title fs-base mb-2"><a href="{{ route('knjiga') }}">Martin Cruz Smith: Vukovi jedu pse</a></h3>

                        <div class="fs-lg text-accent pt-2">100.<small>00kn</small></div>
                    </div>
                </div>
                <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                    <label class="form-label" for="quantity1">Količina</label>
                    <input class="form-control" type="number" id="quantity1" min="1" max="1" value="1" readonly>

                </div>
            </div>




            <!-- Client details-->
            <div class="bg-secondary rounded-3 px-4 pt-4 pb-2">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="h6">Dostaviti na:</h4>
                        <ul class="list-unstyled fs-sm">
                            <li><span class="text-muted">Korisnik:&nbsp;</span>Ivan Horvat</li>
                            <li><span class="text-muted">Adresa:&nbsp;</span>Ozaljska 125, 10000 Zagreb, Hrvatska</li>
                            <li><span class="text-muted">Email:&nbsp;</span>ivan.horvat@email.hr</li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="h6">Način plaćanja:</h4>
                        <ul class="list-unstyled fs-sm">
                            <li><span class="text-muted">Kreditna / debitna kartica:&nbsp;</span>T-Com Payway sustav za internet autorizaciju i naplatu kreditnih i debitnih kartica.</li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Navigation (desktop)-->
            <div class="d-none d-lg-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('naplata') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('success') }}"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>


        </section>
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5 d-none d-lg-block">
            <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
                <div class="py-2 px-xl-2">
                    <div class="widget mb-3">
                        <h2 class="widget-title text-center">Sažetak narudžbe</h2>

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
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('naplata') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('success') }}"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
        </div>
    </div>
</div>

@endsection
