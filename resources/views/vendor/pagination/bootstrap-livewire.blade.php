@if ($paginator->hasPages())
    <div class="row mt-4">
        <div class="col-md-6 d-flex justify-content-center justify-content-md-start  mb-sm-3">
            <nav>
                <ul class="pagination">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled me-2" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item me-2"><a class="page-link" href="#top" data-scroll="" wire:click="previousPage" aria-label="@lang('pagination.previous')">&lsaquo;</a></li>
                    @endif

                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                        <li class="page-item"><a class="page-link" href="#top" data-scroll="" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                            <li class="page-item ms-2"><a class="page-link" href="#top" data-scroll="" wire:click="nextPage" aria-label="@lang('pagination.next')">&rsaquo;</a></li>
                    @else
                            <li class="page-item disabled ms-2" aria-disabled="true" aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true">&rsaquo;</span>
                            </li>
                    @endif
                </ul>
            </nav>
        </div>

        <div class="col-md-6 text-md-end d-flex justify-content-center justify-content-md-end  justify-content-xs-center mt-2">
            <p class="text-sm text-gray-700 leading-5">
                Prikazano
                <span class="font-weight-bold">{{ $paginator->firstItem() }}</span>
                do
                <span class="font-weight-bold">{{ $paginator->lastItem() }}</span>
                od
                <span class="font-weight-bold">{{ $paginator->total() }}</span>
                rezultata
            </p>
        </div>
    </div>
@endif


