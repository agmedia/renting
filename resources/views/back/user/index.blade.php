@extends('back.layouts.backend')
@push('css_before')

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">


@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Korisnici</h1>

            </div>
        </div>
    </div>


    <!-- Page Content -->
    <div class="content">
    @include('back.layouts.partials.session')


        <!-- All Orders -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Svi korisnici (122)</h3>

            </div>
            <div class="block-content bg-body-dark">
                <!-- Search Form -->
                <form action="be_pages_ecom_orders.html" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-alt" id="dm-ecom-orders-search" name="dm-ecom-orders-search" placeholder="Pretraži korisnike">
                    </div>
                </form>
                <!-- END Search Form -->
            </div>
            <div class="block-content">
                <!-- All Orders Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter font-size-sm">
                        <thead>
                        <tr>
                            <th class="text-left">Kupac</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Detalji</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">
                                <a class="font-w600" href="{{ route('users.create') }}">
                                    Pero Perić
                                </a>
                            </td>
                            <td class="text-center">pero.peric@gmail.com</td>
                            <td class="text-center font-size-sm">
                                <i class="fa fa-fw fa-check text-success"></i>
                            </td>
                            <td class="text-right font-size-base">
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('users.create') }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
                <!-- END All Orders Table -->

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
        <!-- END All Orders -->
    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#status-select').select2({
                placeholder: 'Promjenite status'
            });

        })
    </script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endpush
