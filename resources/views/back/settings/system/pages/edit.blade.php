@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">

    <style>
        .cke_skin_kama .cke_button_CMDSuperButton .cke_label {
            display: inline;
        }
    </style>

@endpush

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/pages.uredi') }}</h1>

                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pages') }}">{{ __('back/pages.naslov') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/pages.uredi') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        @include('back.layouts.partials.session')

        <form action="{{ isset($page) ? route('pages.update', ['stranica' => $page]) : route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($page))
                {{ method_field('PATCH') }}
            @endif

            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                        <i class="fa fa-arrow-left mr-1"></i> {{ __('back/pages.povratak') }}
                    </a>
                    <div class="block-options">
                        <div class="custom-control custom-switch custom-control-success block-options-item ml-4">
                            <input type="checkbox" class="custom-control-input" id="status-switch" name="status" @if (isset($page) and $page->status) checked @endif>
                            <label class="custom-control-label"style="padding-top: 2px;" for="status-switch">{{ __('back/apartment.status') }}</label>
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="title-input" class="w-100" >{{ __('back/pages.title') }} <span class="text-danger">*</span>
                                    <ul class="nav nav-pills float-right">
                                        @foreach(ag_lang() as $lang)
                                            <li @if ($lang->code == current_locale()) class="active" @endif ">
                                            <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#title-{{ $lang->code }}">
                                                <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                            </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </label>
                                <div class="tab-content">
                                    @foreach(ag_lang() as $lang)
                                        <div id="title-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                            <input type="text" class="form-control" id="title-input-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($page) ? $page->translation($lang->code)->title : old('title') }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group mb-5">
                                <label for="group-select">{{ __('back/pages.podgrupa') }}</label>
                                <select class="js-select2 form-control" id="group-select" name="group" style="width: 100%;">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group }}" {{ ((isset($page)) and ($page->group == $group)) ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="col-md-12">
                                    <label for="description-editor" class="w-100">{{ __('back/pages.opis') }}
                                        <div class="float-right">
                                            <ul class="nav nav-pills float-right">
                                                @foreach(ag_lang() as $lang)
                                                    <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                    <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#description-{{ $lang->code }}">
                                                        <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                    </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <div class="tab-content">
                                        @foreach(ag_lang() as $lang)
                                            <div id="description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                <textarea id="description-editor-{{ $lang->code }}" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}">{!! isset($page) ? $page->translation($lang->code)->description : old('description') !!}</textarea>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Meta Data - SEO</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 ">
                            <form action="" method="POST" onsubmit="return false;">
                                <div class="form-group">
                                    <label for="meta-title-input" class="w-100">Meta title
                                        <ul class="nav nav-pills float-right">
                                            @foreach(ag_lang() as $lang)
                                                <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#meta-title-{{ $lang->code }}">
                                                    <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </label>
                                    <div class="tab-content">
                                        @foreach(ag_lang() as $lang)
                                            <div id="meta-title-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                <input type="text" class="js-maxlength form-control" id="meta-title-input-{{ $lang->code }}" placeholder="{{ $lang->code }}" name="meta_title[{{ $lang->code }}]" value="{{ isset($page) ? $page->translation($lang->code)->meta_title : old('meta_title') }}" maxlength="70" data-always-show="true" data-placement="top">
                                                <small class="form-text text-muted">
                                                    70 {{ __('back/pages.char') }} max
                                                </small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="meta-description-input"  class="w-100">Meta description
                                            <ul class="nav nav-pills float-right">
                                                @foreach(ag_lang() as $lang)
                                                    <li @if ($lang->code == current_locale()) class="active" @endif ">
                                                    <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#meta-description-{{ $lang->code }}">
                                                        <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                    </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tab-content">
                                            @foreach(ag_lang() as $lang)
                                                <div id="meta-description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                    <textarea class="js-maxlength form-control" id="meta-description-input-{{ $lang->code }}"  placeholder="{{ $lang->code }}" name="meta_description[{{ $lang->code }}]" rows="4" maxlength="160" >{{ isset($page) ? $page->translation($lang->code)->meta_description : old('meta_description') }}</textarea>
                                                    <small class="form-text text-muted">
                                                        160 {{ __('back/pages.char') }} max
                                                    </small>
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push mb-3">
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-hero-success my-2">
                                <i class="fas fa-save mr-1"></i>  {{ __('back/layout.btn.save') }}
                            </button>
                        </div>
                        <div class="col-md-5 text-right">
                            @if (isset($page) && $page->subgroup != '/')
                                <a href="{{ route('pages.destroy', ['stranica' => $page]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/layout.btn.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-page-form{{ $page->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> {{ __('back/layout.btn.delete') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($page))
            <form id="delete-page-form{{ $page->id }}" action="{{ route('pages.destroy', ['stranica' => $page]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('js_after')

    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>



    <script>
        $(() => {
            {!! ag_lang() !!}.forEach(function(item) {
                ClassicEditor
                .create(document.querySelector('#description-editor-' + item.code))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
            });

        })
    </script>


    <script>
        $(() => {
            $('#group-select').select2({
                placeholder: 'Odaberite ili upišite novu grupu...',
                tags: true
            });

            /*editor = CKEDITOR.replace('js-ckeditor'); // bind editor

            editor.addCommand("mySimpleCommand", { // create named command
                exec: function(edt) {
                    alert(edt.getData());
                }
            });

            editor.ui.addButton('SuperButton', { // add new button and bind our command
                label: "Click me",
                command: 'mySimpleCommand',
                //toolbar: 'insert',
                icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
            });*/
        })
    </script>

@endpush
