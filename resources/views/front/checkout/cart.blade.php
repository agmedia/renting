
@extends('front.layouts.app')

@section('content')


<!-- Page Title-->
<div class="page-title-overlap bg-accent pt-4" >
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Košarica</li>
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



            <!-- Autor info-->
            <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
                <h2 class="h6 text-dark mb-0">Artikli</h2><a class="btn btn-secondary btn-sm ps-2" href="{{ route('kategorija') }}"><i class="ci-arrow-left me-2"></i>Nastavi kupnju</a>
            </div>
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
                    <button class="btn btn-link px-0 text-danger" type="button"><i class="ci-close-circle me-2"></i><span class="fs-sm">Ukloni</span></button>
                </div>
            </div>


        </section>
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
            <div class="bg-white rounded-3 shadow-lg p-4">
                <div class="py-2 px-xl-2">
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h2 class="h6 mb-3 pb-1">Ukupno</h2>
                        <h3 class="fw-normal">100.<small>00kn</small></h3>
                    </div>

                    <a class="btn btn-primary btn-shadow d-block w-100 mt-4" href="{{ route('adresa-isporuke') }}"><i class="ci-card fs-lg me-2"></i>Nastavi na naplatu</a>
                </div>
            </div>
        </aside>
    </div>
</div>

@endsection
