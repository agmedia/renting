<div>
    <div class="steps steps-light pt-2 pb-3 mb-5">
        <a class="step-item active" href="{{ route('kosarica') }}">
            <div class="step-progress"><span class="step-count">1</span></div>
            <div class="step-label"><i class="ci-cart"></i>Košarica</div>
        </a>
        <a class="step-item @if($step == 'podaci') current @endif @if(in_array($step, ['podaci', 'dostava', 'placanje'])) active @endif" wire:click="changeStep('podaci')" href="javascript:void(0);">
            <div class="step-progress"><span class="step-count">2</span></div>
            <div class="step-label"><i class="ci-user-circle"></i>Podaci</div>
        </a>
        <a class="step-item @if($step == 'dostava') current @endif @if(in_array($step, ['dostava', 'placanje'])) active @endif" wire:click="changeStep('dostava')" href="javascript:void(0);">
            <div class="step-progress"><span class="step-count">3</span></div>
            <div class="step-label"><i class="ci-package"></i>Dostava</div>
        </a>
        <a class="step-item @if($step == 'placanje') current @endif @if(in_array($step, ['placanje'])) active @endif" wire:click="changeStep('placanje')" href="javascript:void(0);">
            <div class="step-progress"><span class="step-count">4</span></div>
            <div class="step-label"><i class="ci-card"></i>Plaćanje</div>
        </a>
        <a class="step-item" href="{{ ($payment != '') ? route('pregled') : '#' }}">
            <div class="step-progress"><span class="step-count">5</span></div>
            <div class="step-label"><i class="ci-check-circle"></i>Pregledaj</div>
        </a>
    </div>

    @if ($step == 'podaci')
        <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Adresa dostave</h2>

        @if (session()->has('login_success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('login_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (auth()->guest())
            <div class="alert alert-secondary d-flex mb-3" role="alert">
                <div class="alert-icon">
                    <i class="ci-user"></i>
                </div>
                <div><a data-bs-toggle="collapse" href="#collapseLogin" role="button" aria-expanded="false" aria-controls="collapseLogin" class="alert-link">Prijava </a> za registrirane korisnike!</div>
            </div>

            @if (session()->has('error'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div id="collapseLogin" aria-expanded="false" class="collapse">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="si-email">Email adresa</label>
                                    <input class="form-control" type="email" wire:model.defer="login.email" placeholder="" required>
                                    <div class="invalid-feedback">MOlimo upišite ispravnu email adresu.</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="si-password">Lozinka</label>
                                    <div class="password-toggle">
                                        <input class="form-control" type="password" wire:model.defer="login.pass" required>
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3 d-flex flex-wrap justify-content-between">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="login.remember" id="si-remember">
                                        <label class="form-check-label" for="si-remember">Zapamti me</label>
                                    </div>
                                    <a class="fs-sm" href="{{ route('register') }}">Registriraj se..!</a>
                                </div>
                                <button class="btn btn-primary btn-shadow d-block w-100" wire:click="authUser()" type="button">Prijava</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-fn">Ime <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.fname') is-invalid @enderror" type="text" wire:model.defer="address.fname" autocomplete="new-password">
                    @error('address.fname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-ln">Prezime <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.lname') is-invalid @enderror" type="text" wire:model.deferl="address.lname" autocomplete="new-password">
                    @error('address.lname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Prezime je obvezno</div> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-email">E-mail Adresa <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.email') is-invalid @enderror" type="email" wire:model.defer="address.email" autocomplete="new-password">
                    @error('address.email') <div id="val-username-error" class="invalid-feedback animated fadeIn">Email adresa je obavezna</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-phone">Telefon</label>
                    <input class="form-control" type="text" wire:model.defer="address.phone" autocomplete="new-password">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-address">Adresa <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.address') is-invalid @enderror" type="text" wire:model.defer="address.address" autocomplete="new-password">
                    @error('address.address') <div id="val-username-error" class="invalid-feedback animated fadeIn">Adresa je obvezno</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-city">Grad <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.city') is-invalid @enderror" type="text" wire:model.defer="address.city" autocomplete="new-password">
                    @error('address.city') <div id="val-username-error" class="invalid-feedback animated fadeIn">Grad je obvezan</div> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-zip">Poštanski broj <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.zip') is-invalid @enderror" type="text" wire:model.defer="address.zip" autocomplete="new-password">
                    @error('address.zip') <div id="val-username-error" class="invalid-feedback animated fadeIn">Poštanski broj je obvezan</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3" wire:ignore>
                    <label class="form-label" for="checkout-country">Država <span class="text-danger">*</span></label>
                    <select class="form-select @error('address.state') is-invalid @enderror" id="state-select" wire:model="address.state" wire:change="stateSelected($event.target.value)" autocomplete="new-password">
                        <option value=""></option>
                        @foreach ($countries as $country)
                            <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                    @error('address.state') <div id="val-username-error" class="invalid-feedback animated fadeIn">Država je obvezna</div> @enderror
                </div>
            </div>
        </div>

        <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Trebate R1 račun?</h2>
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-company">Tvrtka</label>
                    <input class="form-control" type="text" wire:model="address.company">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label" for="checkout-oib">OIB</label>
                        <input class="form-control" type="text" wire:model="address.oib">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('kosarica') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na košaricu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" wire:click="changeStep('dostava')" href="javascript:void(0);"><span class="d-none d-sm-inline">Na odabir dostave</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>

    @endif


    @if ($step == 'dostava')
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
                @foreach ($shippingMethods as $s_method)
                    <tr wire:click="selectShipping('{{ $s_method->code }}')" style="cursor: pointer;">
                        <td>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" value="{{ $s_method->code }}" wire:model="shipping">
                                <label class="form-check-label" for="courier"></label>
                            </div>
                        </td>
                        <td class="align-middle"><span class="text-dark fw-medium">{{ $s_method->title }}</span><br><span class="text-muted">{{ $s_method->data->short_description }}</span></td>
                        <td class="align-middle">{{ $s_method->data->time }}</td>
                        <td class="align-middle">{{ $s_method->data->price }}kn</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @error('shipping') <small class="text-danger">Način dostave je obvezan</small> @enderror
        <div class=" d-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" wire:click="changeStep('podaci')" href="javascript:void(0);"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na adresu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" wire:click="changeStep('placanje')" href="javascript:void(0);"><span class="d-none d-sm-inline">Na odabir plaćanja</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
    @endif


    @if ($step == 'placanje')
        <h2 class="h6 pt-1 pb-3 mb-3 ">Odaberite način plaćanja</h2>
        <div class="table-responsive">
            <table class="table table-hover fs-sm border-top">
                <tbody>
                @foreach ($paymentMethods as $p_method)
                    <tr wire:click="selectPayment('{{ $p_method->code }}')" style="cursor: pointer;">
                        <td>
                            <div class="form-check mb-2  ">
                                <input class="form-check-input" type="radio" value="{{ $p_method->code }}" wire:model="payment">
                                <label class="form-check-label" for="courier"></label>
                            </div>
                        </td>
                        <td class="align-middle"><span class="text-dark fw-medium">{{ $p_method->title }}</span><br><span class="text-muted">{{ $p_method->data->short_description }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @error('payment') <small class="text-danger">Način plaćanja je obvezan</small> @enderror
        <div class=" d-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" wire:click="changeStep('dostava')" href="javascript:void(0);"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na odabir dostave</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ ($payment != '') ? route('pregled') : '#' }}"><span class="d-none d-sm-inline">Pregledajte narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
    @endif

</div>


@push('js_after')
{{--    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">--}}
{{--    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>--}}

    <script>
        $( document ).ready(function() {
            /*$('#state-select').select2();*/
            $('input').attr('autocomplete','off');
        });
    </script>

@endpush
