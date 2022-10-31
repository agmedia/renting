@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('back/options.title_edit') }}</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('options') }}">{{ __('back/options.title') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('back/options.title_edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content content-full ">

        @include('back.layouts.partials.session')

        <form action="{{ isset($option) ? route('options.update', ['option' => $option]) : route('options.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($option))
                {{ method_field('PATCH') }}
            @endif
            <div class="row">

                <div class="col-md-7">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <a class="btn btn-light" href="{{ back()->getTargetUrl() }}">
                                <i class="fa fa-arrow-left mr-1"></i> {{ __('back/action.back') }}
                            </a>
                            <div class="block-options">
                                <div class="custom-control custom-switch custom-control-info block-options-item ml-4">
                                    <input type="checkbox" class="custom-control-input" id="featured-switch" name="featured" @if (isset($option) and $option->featured) checked @endif>
                                    <label class="custom-control-label" for="featured-switch">{{ __('back/options.title_featured') }}</label>
                                </div>
                                <div class="custom-control custom-switch custom-control-success block-options-item ml-4">
                                    <input type="checkbox" class="custom-control-input" id="status-switch" name="status" @if (isset($option) and $option->status) checked @endif>
                                    <label class="custom-control-label" for="status-switch">{{ __('back/action.publish') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center push">
                                <div class="col-md-12">
                                    <div class="form-group row items-push mb-2">
                                        <div class="col-md-12">
                                            <label for="title-input" class="w-100">{{ __('back/action.title') }} <span class="text-danger">*</span>
                                                <ul class="nav nav-pills float-right">
                                                    @foreach(ag_lang() as $lang)
                                                        <li @if ($lang->code == current_locale()) class="active" @endif>
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
                                                        <input type="text" class="form-control" id="title-input-{{ $lang->code }}" name="title[{{ $lang->code }}]" placeholder="{{ $lang->code }}" value="{{ isset($option) ? $option->translation($lang->code)->title : old('title.*') }}">
                                                        @error('title')
                                                        <span class="text-danger font-italic">Error Title...</span>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row items-push mb-2">
                                        <div class="col-md-12">
                                            <label for="description-input" class="w-100">{{ __('back/options.title_short_desc') }}
                                                <ul class="nav nav-pills float-right">
                                                    @foreach(ag_lang() as $lang)
                                                        <li @if ($lang->code == current_locale()) class="active" @endif>
                                                            <a class="btn btn-sm btn-outline-secondary ml-2 @if ($lang->code == current_locale()) active @endif " data-toggle="pill" href="#description-{{ $lang->code }}">
                                                                <img src="{{ asset('media/flags/' . $lang->code . '.png') }}" />
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </label>
                                            <div class="tab-content">
                                                @foreach(ag_lang() as $lang)
                                                    <div id="description-{{ $lang->code }}" class="tab-pane @if ($lang->code == current_locale()) active @endif">
                                                        <textarea class="form-control" rows="5" name="description[{{ $lang->code }}]">{!! isset($option) ? $option->translation($lang->code)->description : old('description.*') !!}</textarea>
                                                        @error('description')
                                                        <span class="text-danger font-italic">Error Description...</span>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row items-push">
                                        <div class="col-md-4 mt-2">
                                            <label for="price-input">{{ __('back/options.title_price') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="price-input" name="price" value="{{ isset($option) ? $option->price : old('price') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="discount-append-badge">kn</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label for="group-select">Price Per</label>
                                            <select class="form-control" id="price-per-select" name="price_per">
                                                <option value="day" {{ (isset($option) and 'day' == $option->price_per) ? 'selected="selected"' : '' }}>Price Per Day</option>
                                                <option value="onetime" {{ (isset($option) and 'onetime' == $option->price_per) ? 'selected="selected"' : '' }}>One Time Payment</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label for="group-select">Extra Group <span class="text-danger">*</span></label>
                                            <select class="form-control" id="group-select" name="group">
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}" {{ (isset($option) and $group->id == $option->group) ? 'selected="selected"' : '' }}>{{ $group->title }}</option>
                                                @endforeach
                                                <option value="all" {{ (isset($option) and 'all' == $option->group) ? 'selected="selected"' : '' }}>{{ __('back/action.all_units') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="reference-select">Reference</label>
                                            <select class="form-control" id="reference-select" name="reference">
                                                {{--<option value="other" {{ (isset($option) and 'other' == $option->reference) ? 'selected="selected"' : '' }}>Other</option>--}}
                                                @foreach (config('settings.option_references') as $item)
                                                    <option value="{{ $item['reference'] }}" {{ (isset($option) and $item['reference'] == $option->reference) ? 'selected="selected"' : '' }}>{{ $item['title'][current_locale()] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-12 mt-4">
                                            <div class="custom-control custom-switch custom-control-info" id="show-insert-switch">
                                                <input type="checkbox" class="custom-control-input" id="auto-insert-switch" name="auto_insert" @if (isset($option) and $option->auto_insert) checked @endif>
                                                <label class="custom-control-label" for="auto-insert-switch">Insert it automatically on every order!</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-hero-success mb-3">
                                        <i class="fas fa-save mr-1"></i> {{ __('back/action.save') }}
                                    </button>
                                </div>
                                @if (isset($option))
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('options.destroy', ['option' => $option]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/action.delete') }}" onclick="event.preventDefault(); document.getElementById('delete-action-form{{ $option->id }}').submit();">
                                            <i class="fa fa-trash-alt"></i> {{ __('back/action.delete') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-5" id="action-list-view">
                    @if (isset($option))
                        @livewire('back.marketing.action-group-list', ['group' => $option->group, 'list' => json_decode($option->links)])
                    @else
                        @livewire('back.marketing.action-group-list', ['group' => 'apartment'])
                    @endif
                </div>
            </div>
        </form>

        @if (isset($option))
            <form id="delete-action-form{{ $option->id }}" action="{{ route('options.destroy', ['option' => $option]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        /**
         * 
         * @param reference
         * @param target
         */
        function showAutoInsert(reference, target) {
            if (reference == 'person') {
                target.hide();
            } else {
                target.show();
            }
        }

        $(() => {

            showAutoInsert($('#reference-select').val(), $('#show-insert-switch'));
            /**
             *
             */
            $('#price-per-select').select2({
                minimumResultsForSearch: Infinity
            });

            $('#group-select').select2({
                minimumResultsForSearch: Infinity
            });
            $('#group-select').on('change', function (e) {
                Livewire.emit('groupUpdated', e.currentTarget.value);
            });

            $('#reference-select').select2({
                minimumResultsForSearch: Infinity
            });

            $('#reference-select').on('change', e => {
                showAutoInsert(e.currentTarget.value, $('#show-insert-switch'));
            })


            Livewire.on('list_full', () => {
                $('#group-select').attr("disabled", true);
            });
            Livewire.on('list_empty', () => {
                $('#group-select').attr("disabled", false);
            });

            @if (isset($option) && $option->group != 'all')
                $('#group-select').attr("disabled", true);
            @endif
        })
    </script>

@endpush
