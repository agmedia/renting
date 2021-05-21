
@extends('front.layouts.app')

@section('content')


<!-- Page Title-->
<div class="page-title-overlap bg-accent pt-4" >
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Način dostave</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Način dostave</h1>
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
            <h2 class="h6 pt-1 pb-3 mb-3 ">Odaberite način dostave</h2>


            <div class="table-responsive">
                <table class="table table-hover fs-sm border-top">
                    <thead>
                    <tr>
                        <th class="align-middle"></th>
                        <th class="align-middle">Dostava</th>
                        <th class="align-middle">Vrijeme dostave</th>
                        <th class="align-middle">Cijena</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" id="courier" name="shipping-method" checked>
                                <label class="form-check-label" for="courier"></label>
                            </div>
                        </td>
                        <td class="align-middle"><span class="text-dark fw-medium">GLS-Croatia.</span><br><span class="text-muted">Dostava se vrši putem GLS dostavne službe. </span></td>
                        <td class="align-middle">1-2 radna dana</td>
                        <td class="align-middle">25kn</td>
                    </tr>

                    </tbody>
                </table>
            </div>


            <!-- Navigation (desktop)-->
            <div class="d-none d-lg-flex pt-4 mt-3">
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('adresa-isporuke') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na adresu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('naplata') }}"><span class="d-none d-sm-inline">Na odabir plaćanja</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
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
                <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('adresa-isporuke') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na adresu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
                <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ route('naplata') }}"><span class="d-none d-sm-inline">Na odabir plaćanja</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
        </div>
    </div>
</div>

@endsection
