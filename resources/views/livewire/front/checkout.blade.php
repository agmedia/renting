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
        <div class="row">
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
                    <label class="form-label" for="checkout-address">Adresa</label>
                    <input class="form-control @error('address.address') is-invalid @enderror" type="text" wire:model="address.address">
                    @error('address.address') <div id="val-username-error" class="invalid-feedback animated fadeIn">Ime je obvezno</div> @enderror
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
                <div class="mb-3">
                    <label class="form-label" for="checkout-country">Država</label>
                    <select class="form-select" id="checkout-country" wire:model="address.state">
                        <option>Odaberite državu</option>
                        <option>Hrvatska</option>
                        <option>Austria</option>
                        <option>...</option>
                    </select>
                </div>
            </div>
        </div>

        @if (auth()->guest())
            <h6 class="mb-3 py-3 border-bottom">Registracija</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" checked id="same-address">
                <label class="form-check-label" for="same-address">Ujedno napravi i korisnički račun</label>
            </div>
        @endif
        <!-- Navigation (desktop)-->
        <div class="d-none d-lg-flex pt-4 mt-3">
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
                <tr wire:click="selectShipping('gls')" style="cursor: pointer;">
                    <td>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" value="gls" wire:model="shipping">
                            <label class="form-check-label" for="courier"></label>
                        </div>
                    </td>
                    <td class="align-middle"><span class="text-dark fw-medium">GLS-Croatia.</span><br><span class="text-muted">Dostava se vrši putem GLS dostavne službe.</span></td>
                    <td class="align-middle">1-2 radna dana</td>
                    <td class="align-middle">25kn</td>
                </tr>
                </tbody>
            </table>
        </div>
        @error('shipping') <small class="text-danger">Način dostave je obvezan</small> @enderror
        <div class="d-none d-lg-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" wire:click="changeStep('podaci')" href="javascript:void(0);"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na adresu</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" wire:click="changeStep('placanje')" href="javascript:void(0);"><span class="d-none d-sm-inline">Na odabir plaćanja</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
    @endif



    @if ($step == 'placanje')
        <h2 class="h6 pt-1 pb-3 mb-3 ">Odaberite način plaćanja</h2>
        <div class="table-responsive">
            <table class="table table-hover fs-sm border-top">
                <tbody>
                <tr wire:click="selectPayment('card')" style="cursor: pointer;">
                    <td>
                        <div class="form-check mb-2  ">
                            <input class="form-check-input" type="radio" value="card" wire:model="payment">
                            <label class="form-check-label" for="courier"></label>
                        </div>
                    </td>
                    <td class="align-middle"><span class="text-dark fw-medium">Kreditnom karticom</span><br><span class="text-muted">T-Com Payway sustav za internet autorizaciju i naplatu kreditnih i debitnih kartica. </span></td>
                </tr>
                <tr wire:click="selectPayment('bank')" style="cursor: pointer;">
                    <td>
                        <div class="form-check mb-2 mt-2">
                            <input class="form-check-input" type="radio" value="bank" wire:model="payment">
                            <label class="form-check-label" for="courier"></label>
                        </div>
                    </td>
                    <td class="align-middle"><span class="text-dark fw-medium">Općom uplatnicom / Virmanom / Internet bankarstvom</span><br><span class="text-muted">Uplatite direktno na naš bankovni račun. Uputstva i uplatnice vam stiže putem maila.</span></td>
                </tr>
                <tr wire:click="selectPayment('cash')" style="cursor: pointer;">
                    <td>
                        <div class="form-check mb-2 mt-2">
                            <input class="form-check-input" type="radio" value="cash" wire:model="payment">
                            <label class="form-check-label" for="courier"></label>
                        </div>
                    </td>
                    <td class="align-middle"><span class="text-dark fw-medium">Gotovinom prilikom pouzeća</span><br><span class="text-muted">Plaćanje gotovinom prilikom preuzimanja. </span></td>
                </tr>
                </tbody>
            </table>
        </div>
        @error('payment') <small class="text-danger">Način plaćanja je obvezan</small> @enderror
        <div class="d-none d-lg-flex pt-4 mt-3">
            <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" wire:click="changeStep('dostava')" href="javascript:void(0);"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na odabir dostave</span><span class="d-inline d-sm-none">Povratak</span></a></div>
            <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="{{ ($payment != '') ? route('pregled') : '#' }}"><span class="d-none d-sm-inline">Pregledajte narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
        </div>
    @endif

</div>
