@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Naslovnica</a></li>

                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Moji podaci</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">Moj račun</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
                <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
                    <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                        <div class="d-md-flex align-items-center">
                            <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="{{ asset('media/img/faviconbiblos.png') }}" alt="Susan Gardner"></div>
                            <div class="ps-md-3">
                                <h3 class="fs-base mb-0">Miroslav Škoro</h3><span class="text-accent fs-sm">mskoro@dp.hr</span>
                            </div>
                        </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Navigacija</a>
                    </div>
                    <div class="d-lg-block collapse" id="account-menu">
                        <div class="bg-secondary px-4 py-3">
                            <h3 class="fs-sm mb-0 text-muted">Moj korisnički račun</h3>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="{{ route('moj-racun') }}"><i class="ci-user opacity-60 me-2"></i>Moji podaci</a></li>

                            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('moje-narudzbe') }}"><i class="ci-bag opacity-60 me-2"></i>Narudžbe<span class="fs-sm text-muted ms-auto">1</span></a></li>

                            <li class="d-lg-none  mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}"><i class="ci-sign-out opacity-60 me-2"></i>Odjava</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                    <h6 class="fs-base text-light mb-0">Uredite svoje podatke ispod:</h6><a class="btn btn-primary btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Odjava</a>
                </div>
                <!-- Profile form-->
                <form>

                        <div class="row ">
                            <div class="col-sm-12">
                            <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Osnovni podaci</h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-fn">Ime</label>
                                    <input class="form-control @error('address.fname') is-invalid @enderror" type="text" wire:model="address.fname">
                                    @error('address.fname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-ln">Prezime</label>
                                    <input class="form-control @error('address.lname') is-invalid @enderror" type="text" wire:model="address.lname">
                                    @error('address.lname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-email">E-mail Adresa</label>
                                    <input class="form-control @error('address.email') is-invalid @enderror" type="email" wire:model="address.email" readonly>
                                    @error('address.email') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-phone">Telefon</label>
                                    <input class="form-control" type="text" wire:model="address.phone">
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                            <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Adresa dostave</h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                    <label class="form-label" for="checkout-address">Adresa</label>
                                    <input class="form-control @error('address.address') is-invalid @enderror" type="text" wire:model="address.address">
                                    @error('address.address') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-city">Grad</label>
                                    <input class="form-control @error('address.city') is-invalid @enderror" type="text" wire:model="address.city">
                                    @error('address.city') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="checkout-zip">Poštanski broj</label>
                                    <input class="form-control @error('address.zip') is-invalid @enderror" type="text" wire:model="address.zip">
                                    @error('address.zip') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3" wire:ignore>
                                    <label class="form-label" for="checkout-country">Država</label>
                                    <select class="form-select g @error('address.state') is-invalid @enderror" id="checkout-country" wire:model="address.state">
                                        <option value=""></option>
                                    {{--    @foreach ($countries as $country)
                                            <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                        @endforeach--}}
                                    </select>
                                    @error('address.state') <div id="val-username-error" class="invalid-feedback animated fadeIn">Država je obvezna</div> @enderror
                                </div>
                            </div>
                        </div>
                         <div class="row ">
                                 <div class="col-sm-12">
                                     <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Lozinka</h2>
                                 </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="account-pass">Lozinka</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" id="account-pass">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="account-confirm-pass">Potvrdite lozinku</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" id="account-confirm-pass">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                            <hr class="mt-5 mb-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">

                                <button class="btn btn-primary mt-3 mt-sm-0" type="button">Snimi izmjene</button>
                            </div>
                        </div>
                    </div>

                </form>
            </section>
        </div>
    </div>

@endsection
