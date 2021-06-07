@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Korisnik edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('users') }}">Korisnici</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Korisnik edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content content-full content-boxed">

        @include('back.layouts.partials.session')
        <div class="block block-rounded">

            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                    <i class="fa fa-arrow-left mr-1"></i> Povratak
                </a>
                <div class="block-options">
                    <div class="custom-control custom-switch custom-control-success">
                        <input type="checkbox" class="custom-control-input" id="dm-post-edit-active" name="dm-post-edit-active" >
                        <label class="custom-control-label" for="dm-post-edit-active">Aktiviraj</label>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <form action="be_pages_projects_edit.html" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                    <!-- User Profile -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> Korisnički profil
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Osnovni podaci o korisniku
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="form-group">
                                <label for="dm-profile-edit-username">Korisničko ime</label>
                                <input type="text" class="form-control" id="dm-profile-edit-username" name="dm-profile-edit-username" placeholder="Unesite vaše korisničko ime.." value="Pero Perić">
                            </div>

                            <div class="form-group">
                                <label for="dm-profile-edit-email">Email adresa</label>
                                <input type="email" class="form-control" id="dm-profile-edit-email" name="dm-profile-edit-email" placeholder="Unesite vaš email..." value="pero.peric@example.com">
                            </div>

                            <div class="form-group">
                                <label for="dm-profile-edit-email">Telefon</label>
                                <input type="email" class="form-control" id="dm-profile-edit-tel" name="dm-profile-edit-tel" placeholder="Unesite vaš broj telefona..." value="099 25252 369">
                            </div>

                        </div>
                    </div>
                    <!-- END User Profile -->

                    <!-- Change Password -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-asterisk text-muted mr-1"></i> Promjena lozinke
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Resetirajte lozinku kupca
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="form-group">
                                <label for="dm-profile-edit-password">Trenutna lozinka</label>
                                <input type="password" class="form-control" id="dm-profile-edit-password" name="dm-profile-edit-password">
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="dm-profile-edit-password-new">Nova lozinka</label>
                                    <input type="password" class="form-control" id="dm-profile-edit-password-new" name="dm-profile-edit-password-new">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="dm-profile-edit-password-new-confirm">Potvrdite novu lozinku</label>
                                    <input type="password" class="form-control" id="dm-profile-edit-password-new-confirm" name="dm-profile-edit-password-new-confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Change Password -->



                    <!-- Billing Information -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> Korisnički podaci
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">Info za dostavu i izradu računa
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">

                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="dm-profile-edit-firstname">Ime</label>
                                    <input type="text" class="form-control" id="dm-profile-edit-firstname" name="dm-profile-edit-firstname">
                                </div>
                                <div class="col-6">
                                    <label for="dm-profile-edit-lastname">Prezime</label>
                                    <input type="text" class="form-control" id="dm-profile-edit-lastname" name="dm-profile-edit-lastname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-street-1">Adresa</label>
                                <input type="text" class="form-control" id="dm-profile-edit-street-1" name="dm-profile-edit-street-1">
                            </div>

                            <div class="form-group">
                                <label for="dm-profile-edit-city">Grad</label>
                                <input type="text" class="form-control" id="dm-profile-edit-city" name="dm-profile-edit-city">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-postal">Poštanski broj</label>
                                <input type="text" class="form-control" id="dm-profile-edit-postal" name="dm-profile-edit-postal">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-city">Država</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-company-name">Naziv tvrtke </label>
                                <input type="text" class="form-control" id="dm-profile-edit-company-name" name="dm-profile-edit-company-name">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-vat">OIB</label>
                                <input type="text" class="form-control" id="dm-profile-edit-vat" name="dm-profile-edit-vat" value="HR" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- END Billing Information -->


                </form>
            </div>
            <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-hero-success my-2">
                            <i class="fas fa-save mr-1"></i> Snimi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')

@endpush
