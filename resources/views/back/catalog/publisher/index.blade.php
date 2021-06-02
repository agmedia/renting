@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Izdavači</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('publishers.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> Novi izdavač</span>
                </a>
            </div>
        </div>
    </div>



    <div class="content">
    @include('back.layouts.partials.session')
    <!-- All Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Svi izdavači</h3>

            </div>
            <div class="block-content bg-body-dark">
                <!-- Search Form -->
                <form action="be_pages_ecom_products.html" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" class="form-control " id="dm-ecom-products-search" name="dm-ecom-products-search" placeholder="Pretraži izdavače">
                    </div>
                </form>
                <!-- END Search Form -->
            </div>
            <div class="block-content">
                <!-- All Products Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th >Naziv</th>
                            <th style="width: 100px;" class="text-right">Status</th>
                            <th style="width: 100px;" class="text-right">Uredi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr> <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class=" font-size-sm">
                                <a class="font-w600" href="{{ route('publishers.create') }}">
                                    <strong>Algoritam</strong>
                                </a>
                            </td>
                            <td class="text-right" >
                                <span class="badge badge-success">Aktivan</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>




                        </tbody>
                    </table>
                </div>
                <!-- END All Products Table -->

                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination justify-content-end mt-2">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Prethodna">
                                Prethodna
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0)">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" aria-label="Sljedeća">
                                Sljedeća
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Products -->
    </div>
@endsection

@push('js_after')

@endpush
