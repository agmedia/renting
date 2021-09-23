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

        @if (auth()->guest())
        <div class="alert alert-secondary d-flex mb-3" role="alert">
            <div class="alert-icon">
                <i class="ci-user"></i>
            </div>
            <div><a href="{{ route('login') }}" class="alert-link">Prijava </a> za registrirane korisnike!</div>
        </div>

<!--        <div id="collapseLogin" aria-expanded="false" class="collapse">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="si-email">Email adresa</label>
                            <input class="form-control" type="email" id="si-email" placeholder="" required>
                            <div class="invalid-feedback">MOlimo upišite ispravnu email adresu.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="si-password">Lozinka</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="si-password" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="mb-3 d-flex flex-wrap justify-content-between">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="si-remember">
                                <label class="form-check-label" for="si-remember">Zapamti me</label>
                            </div><a class="fs-sm" href="#">Zaboravljena lozinka?</a>
                        </div>
                        <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Prijava</button>
                    </div>
                </div>
                </div>
            </div>
        </div>-->
        @endif

        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-fn">Ime <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.fname') is-invalid @enderror" type="text" wire:model="address.fname">
                    @error('address.fname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-ln">Prezime <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.lname') is-invalid @enderror" type="text" wire:model="address.lname">
                    @error('address.lname') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-email">E-mail Adresa <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.email') is-invalid @enderror" type="email" wire:model="address.email">
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
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-address">Adresa <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.address') is-invalid @enderror" type="text" wire:model="address.address">
                    @error('address.address') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-city">Grad <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.city') is-invalid @enderror" type="text" wire:model="address.city">
                    @error('address.city') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label" for="checkout-zip">Poštanski broj <span class="text-danger">*</span></label>
                    <input class="form-control @error('address.zip') is-invalid @enderror" type="text" wire:model="address.zip">
                    @error('address.zip') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3" wire:ignore>
                    <label class="form-label" for="checkout-country">Država <span class="text-danger">*</span></label>
                    <select class="form-select g @error('address.state') is-invalid @enderror" id="checkout-country" wire:model="address.state">
                        <option value=""></option>
                        @foreach ($countries as $country)
                            <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                    @error('address.state') <div id="val-username-error" class="invalid-feedback animated fadeIn">Država je obvezna</div> @enderror
                </div>
            </div>
        </div>



        <div class="form-check">
            <input class="form-check-input" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" id="napraviracun" type="checkbox" >
            <label class="form-check-label" for="napraviracun" >Trebam <strong>R1 račun</strong></label>

        </div>

        <div id="collapseExample" aria-expanded="false" class="collapse">
            <div class="card mb-3 mt-3">
                <div class="card-body">
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
                </div>
            </div>
        </div>

        @if (auth()->guest())
<!--            <h6 class="mb-3 py-3 border-bottom">Registracija</h6>
            <div class="form-check">
                <input class="form-check-input" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" id="napraviracun" type="checkbox" >
                <label class="form-check-label" for="napraviracun" >Ujedno napravi i korisnički račun </label>

            </div>

            <div id="collapseExample" aria-expanded="false" class="collapse">
                <div class="card mb-3 mt-3">
                    <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div class="mb-3">
                            <label class="form-label" for="su-password">Lozinka</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="su-password" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                             <div class="mb-3">
                            <label class="form-label" for="su-password-confirm">Potvrdite lozinku</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="su-password-confirm" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>-->
        @endif

        <!-- Navigation (desktop)-->
        <div class="d-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('kosarica') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na košaricu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" wire:click="changeStep('dostava')" href="javascript:void(0);"><span class="d-none d-sm-inline">Na odabir dostave</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>

        <!-- Navigation (mobile)-->



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
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function() {
            /*$('#checkout-country').select2({
                placeholder: 'Odaberite državu...',
                //minimumResultsForSearch: Infinity
            });*/

            $('#checkout-country').on('change', (e) => {
                console.log(e.currentTarget.value)
                @this.stateSelected(e.currentTarget.value);
            });
        });

        Livewire.on('shipping_selected', () => {
            console.log('shipping_selected');

            //$store.state.service.getCart();
            console.log(Vuex)
        });
    </script>
    <script>
    $( document ).ready(function() {
    $('input').attr('autocomplete','off');
    });
    </script>

@endpush
