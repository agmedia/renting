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
                <!-- Tasks, custom functionality is initialized in js/pages/be_pages_projects_tasks.min.js which was auto compiled from _js/pages/be_pages_projects_tasks.js -->

                    <!-- Add task -->

                    <!-- END Add task -->

                    <!-- Tasks List -->
                    <h2 class="content-heading pb-0 mb-3 border-0">
                        Ukupno <span class="js-task-badge badge badge-pill badge-light animated fadeIn">2</span>
                    </h2>


                        <!-- Task -->
                        <div class=" block block-rounded mb-2 animated fadeIn" >
                            <table class="table table-borderless bg-body  table-vcenter mb-0">
                                <tr>
                                    <td class="js-task-content font-w600 pl-3">
                                        Knjige
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- END Task -->


                            <!-- Task -->
                            <div class=" block block-rounded mb-2 ml-3 animated fadeIn" >
                                <table class="table table-borderless table-vcenter mb-0">
                                    <tr>
                                        <td class="js-task-content font-w600 pl-3">
                                            Alternativa
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                                <!-- END Task -->

                <!-- Task -->
                <div class=" block block-rounded mb-2 ml-3 animated fadeIn" >
                    <table class="table table-borderless table-vcenter mb-0">
                        <tr>
                            <td class="js-task-content font-w600 pl-3">
                                Antropozofija
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- END Task -->


                </div>
            </div>
        </div>

    </div>


    @include('back.layouts.partials.session')

@endsection

@push('js_after')



    <script src="{{ asset('js/pages/be_pages_projects_tasks.min.js') }}"></script>

@endpush
