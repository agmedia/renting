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
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    @forelse($history as $item)
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h{{ $item->id }}">
                                <a class="h4 block-title" style="line-height: 1.4rem;" data-toggle="collapse" data-parent="#accordion" href="#accordion_q{{ $item->id }}" aria-expanded="false{{--@if($loop->first) true @else false @endif--}}" aria-controls="accordion_q{{ $item->id }}">
                                    {{ $item->title }}<br>
                                    <span class="font-weight-lighter" style="font-size: .72rem;">Korisnik: <strong class="text-info">{{ $item->user()->name }}</strong></span>
                                    <span class="font-weight-lighter" style="font-size: .72rem; margin-left: 18px;">Datum: <strong class="text-info">{{ $item->created_at->format('d.m.Y - h:i') }}</strong></span>
                                </a>
                                <div class="block-options">
                                    <div class="btn-group">
                                        <a href="{{ route('history.show', ['history' => $item->id]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Uredi">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div id="accordion_q{{ $item->id }}" class="collapse {{--@if($loop->first) show @endif--}}" role="tabpanel" aria-labelledby="accordion_h{{ $item->id }}" data-parent="#accordion">
                                <div class="block-content pb-4">
                                    {!! $item->changes !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3>Nemate niti jedan history log...</h3>
                    @endforelse
                </div>
                {{ $history->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/pages/be_pages_projects_tasks.min.js') }}"></script>
@endpush
