@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">

    @stack('product_css')
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/apartment.edit') }}</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('apartments') }}">{{ __('back/apartment.titles') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/apartment.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <!-- Full Calendar (functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _js/pages/be_comp_calendar.js ) -->
    <!-- For more info and examples you can check out https://fullcalendar.io/ -->
    <div class="row no-gutters flex-xl-10-auto">
        @include('back.layouts.partials.session')

        <div class="col-xl-3">
            <div class="content">
                <!-- Toggle Side Content -->
                <div class="d-xl-none push">
                    <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                    <button type="button" class="btn btn-block btn-alt-primary" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                        Calendar Options
                    </button>
                </div>
                <!-- END Toggle Side Content -->

                <!-- Side Content -->
                <div id="side-content" class="d-none d-xl-block push">
                    <!-- Add Event Form -->
                    <form class="js-form-add-event push">
                        <div class="input-group">
                            <input type="text" class="js-add-event form-control border-0" placeholder="Add Event..">
                            <div class="input-group-append">
                                            <span class="input-group-text border-0 bg-white">
                                                <i class="fa fa-fw fa-plus-circle"></i>
                                            </span>
                            </div>
                        </div>
                    </form>
                    <!-- END Add Event Form -->

                    <!-- Event List -->
                    <ul id="js-events" class="list list-events">
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">Codename X</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Weekend Adventure</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">Project Mars</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-warning">Meeting</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Walk the dog</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-info">AI schedule</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-success">Cinema</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-danger">Project X</div>
                        </li>
                        <li>
                            <div class="js-event p-2 text-white font-size-sm font-w500 bg-warning">Skype Meeting</div>
                        </li>
                    </ul>
                    <div class="text-center">
                        <em class="font-size-sm text-muted">
                            <i class="fa fa-arrows-alt"></i> Drag and drop events on the calendar
                        </em>
                    </div>
                    <!-- END Event List -->
                </div>
                <!-- END Side Content -->
            </div>
        </div>
        <div class="col-xl-9 bg-body-dark">
            <div class="content">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <!-- Calendar Container -->
                        <div id="js-calendar" class="p-xl-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/main.min.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['datepicker']);});</script>

    <script>
        $(() => {
            ClassicEditor
            .create(document.querySelector('#description-editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

            $('#category-select').select2({});
            $('#tax-select').select2({});
            $('#action-select').select2({
                placeholder: 'Odaberite...',
                minimumResultsForSearch: Infinity
            });
            $('#author-select').select2({
                tags: true
            });
            $('#publisher-select').select2({
                tags: true
            });
            $('#letter-select').select2({
                tags: true
            });
            $('#binding-select').select2({
                tags: true
            });
            $('#condition-select').select2({
                tags: true
            });

            Livewire.on('success_alert', () => {

            });

            Livewire.on('error_alert', (e) => {

            });
        })
    </script>

    <script>
        function SetSEOPreview() {
            let title = $('#name-input').val();
            $('#slug-input').val(slugify(title));
        }
    </script>

    @stack('product_scripts')

@endpush
