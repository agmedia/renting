@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/faq.uredi') }} </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('faqs') }}">FAQ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/faq.uredi') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        @include('back.layouts.partials.session')

        <form action="{{ isset($faq) ? route('faqs.update', ['faq' => $faq]) : route('faqs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($faq))
                {{ method_field('PATCH') }}
            @endif
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                        <i class="fa fa-arrow-left mr-1"></i> {{ __('back/faq.povratak') }}
                    </a>
                    <div class="block-options">
                        <div class="custom-control custom-switch custom-control-success">
                            <input type="checkbox" class="custom-control-input" id="faq-switch" name="status"{{ (isset($faq->status) and $faq->status) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="faq-switch">{{ __('back/faq.aktiviraj') }} </label>
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">

                            <div class="form-group">

                                <label for="dm-post-edit-title" class="w-100" >{{ __('back/faq.pitanje') }} <span class="text-danger">*</span>
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
                                            <input type="text" class="form-control" id="title-input-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($faq) ? $faq->title : old('title') }}" onkeyup="SetSEOPreview()">
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="form-group row  mb-4">
                                <div class="col-md-12">
                                    <label for="description-editor" class="w-100">{{ __('back/faq.odgovor') }}
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
                                            <textarea id="description-editor-{{ $lang->code }}" name="description[{{ $lang->code }}]" placeholder="{{ $lang->code }}">{!! isset($faq) ? $faq->description : old('description') !!}</textarea>
                                        </div>
                                    @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-hero-success my-2">
                                <i class="fas fa-save mr-1"></i> {{ __('back/layout.btn.save') }}
                            </button>
                        </div>
                        @if (isset($faq))
                            <div class="col-md-5 text-right">
                                <a href="{{ route('faqs.destroy', ['faq' => $faq]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/layout.btn.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-faq-form{{ $faq->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> {{ __('back/layout.btn.delete') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if (isset($faq))
            <form id="delete-faq-form{{ $faq->id }}" action="{{ route('faqs.destroy', ['faq' => $faq]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>





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

@endpush
