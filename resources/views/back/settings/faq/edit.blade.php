@extends('back.layouts.backend')


@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">FAQ edit</h1>
            </div>
        </div>
    </div>



    <!-- Page Content -->
    <div class="content content-full content-boxed">
    @include('back.layouts.partials.session')
    <!-- New Post -->

        <div class="block">
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
                <div class="row justify-content-center push">
                    <div class="col-md-10">

                        <div class="form-group">
                            <label for="dm-post-edit-title">Pitanje</label>
                            <input type="text" class="form-control" id="dm-post-edit-title" name="dm-post-edit-title" placeholder="Unesite naslov..." value="Dvostruki je užitak spasiti vrijednu staru knjigu i još zaraditi na tome">
                        </div>


                        <div class="form-group row  mb-4">
                            <div class="col-md-12">
                                <label for="dm-post-edit-slug">Odgovor</label>
                                <!-- CKEditor 5 Classic Container -->
                                <div id="js-ckeditor5-classic" name="description">Naručene knjige možete preuzeti osobno u Antikvarijatu Biblos, Palmotićeva 28 (križanje
                                    Đorđićeve i Palmotićeve ulice), Zagreb, radnim danom od 09 do 20 sati, subotom od 09 do 14
                                    sati te na taj način uštedjeti trošak dostave.
                                    Svakom kupcu javimo kada su knjige spremne za preuzimanje pa je potrebno pričekati našu
                                    obavijest putem e-maila ili telefonskog broja koji ste ostavili kao kontakt u Vašoj narudžbi.</div>
                            </div>
                        </div>


                    </div>
                </div>
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


        <!-- END New Post -->
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')


    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>


    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['ckeditor5']);});</script>

@endpush
