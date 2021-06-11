@extends('back.layouts.backend')

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Kategorije</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('category.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> Nova kategorija</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="row no-gutters flex-md-10-auto">
        <div class="col-md-12 order-md-0 bg-body-dark">
            <!-- Main Content -->
            <div class="content content-full">
            @include('back.layouts.partials.session')
                <!-- Tasks, custom functionality is initialized in js/pages/be_pages_projects_tasks.min.js which was auto compiled from _js/pages/be_pages_projects_tasks.js -->
                <h2 class="content-heading pb-0 mb-3 border-0">
                    Ukupno <span class="js-task-badge badge badge-pill badge-light animated fadeIn">2</span>
                </h2>

                <div id="accordion" role="tablist" aria-multiselectable="true">
                    @forelse($categories as $group => $categories)
                        <div class="block block-rounded mb-3">

                            <div class="block-header block-header-default" role="tab" id="accordion_h1">
                                <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_q1" aria-expanded="@if($loop->first) true @else false @endif" aria-controls="accordion_q1">{{ $group }}</a>
                            </div>

                            <div id="accordion_q1" class="collapse @if($loop->first) show @endif" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion">
                                <div class="block-content">

                                    @forelse($categories as $category)
                                        <div class=" block block-rounded mb-2 animated fadeIn">
                                            <table class="table table-borderless bg-body table-vcenter mb-0">
                                                <tr>
                                                    <td class="js-task-content font-w600 pl-3">
                                                        {{ $category->title }}
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('category.edit', ['category' => $category]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        @if ($category->subcategories)
                                            @foreach($category->subcategories()->get() as $subcategory)
                                                <div class="block block-rounded mb-2 ml-3 animated fadeIn" style="border: 1px solid #eaeaea">
                                                    <table class="table table-borderless table-vcenter mb-0">
                                                        <tr>
                                                            <td class="js-task-content font-w600 pl-3">
                                                                {{ $subcategory->title }}
                                                            </td>
                                                            <td class="text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{ route('category.edit', ['category' => $subcategory]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                                        <i class="fa fa-pencil-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            @endforeach
                                        @endif

                                    @empty
                                        <h3>Kategorije su prazne. Napravite <a href="{{ route('category.create') }}">novu.</a></h3>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3>Nemate niti jednu grupu kategorija. Trebali bi napraviti <a href="{{ route('category.create') }}">novu kategoriju</a> i upisati grupu.</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/pages/be_pages_projects_tasks.min.js') }}"></script>
@endpush
