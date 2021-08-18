@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4" style="background-image: url({{ asset('media/img/indexslika.jpg') }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">

            @if ($group)
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            @if ($group && ! $cat && ! $subcat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::ucfirst($group) }}</li>
                            @elseif ($group && $cat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group]) }}">{{ \Illuminate\Support\Str::ucfirst($group) }}</a></li>
                            @endif
                            @if ($cat && ! $subcat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $cat->title }}</li>
                            @elseif ($cat && $subcat)
                                <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group, 'cat' => $cat]) }}">{{ $cat->title }}</a></li>
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $subcat->title }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    @if ($group && ! $cat && ! $subcat)
                        <h1 class="h3 text-light mb-0">{{ \Illuminate\Support\Str::ucfirst($group) }}</h1>
                    @endif
                    @if ($cat && ! $subcat)
                        <h1 class="h3 text-light mb-0">{{ $cat->title }}</h1>
                    @elseif ($cat && $subcat)
                        <h1 class="h3 text-light mb-0">{{ $subcat->title }}</h1>
                    @endif
                </div>
            @endif

            @if (isset($author) && $author)
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route.author') }}">Autori</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $author->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h3 text-light mb-0">{{ $author->title }}</h1>
                </div>
            @endif

        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            @if (isset($author) && $author)
                @livewire('front.partials.author-filter', ['author' => $author])
            @elseif (isset($publisher) && $publisher)
                @livewire('front.partials.author-filter', ['publisher' => $publisher])
            @else
                @livewire('front.partials.catalog-filter', ['group' => $group, 'category' => $cat, 'subcategory' => $subcat])
            @endif
            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
                    <div class="d-flex flex-wrap">
                        <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                            <label class="text-light opacity-75 text-nowrap fs-sm me-2 d-none d-sm-block" for="sorting">Sortiraj:</label>
                            <select class="form-select" id="sorting-select">
                                @foreach (config('settings.sorting_list') as $item)
                                    <option value="{{ $item['value'] }}" @if(request()->get('sort') == $item['value']) selected @endif>{{ $item['title'] }}</option>
                                @endforeach
                            </select>
                            <span class="fs-sm text-light opacity-75 text-nowrap ms-2 d-none d-md-block">od {{ $products->total() }} artikala</span>
                        </div>
                    </div>
                    <div class="d-flex pb-3"><a class="nav-link-style nav-link-light me-3" href="#"><i class="ci-arrow-left"></i></a><span class="fs-md text-light">{{ $products->currentPage() }} / {{ $products->lastPage() }}</span><a class="nav-link-style nav-link-light ms-3" href="#"><i class="ci-arrow-right"></i></a></div>
                </div>
                <!-- Products grid-->
                <div class="row mx-n2">
                    @forelse ($products as $product)
                        @include('front.catalog.category.product')
                    @empty
                        <div class="col-md-12 px-2 mb-4">
                            <h2>Nema proizvoda...</h2>
                            <hr class="d-sm-none">
                        </div>
                    @endforelse
                </div>

                <hr class="my-3">

                {{ $products->links() }}
            </section>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        $(() => {
            //
            $('#sorting-select').on('change', (e) => {
                setURL('sort', e.currentTarget.selectedOptions[0]);
            });
        });

        /**
         *
         * @param type
         * @param search
         */
        function setURL(type, search) {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            if (search.value) {
                params.append(type, search.value);
            }

            url.search = params;
            location.href = url;
        }

    </script>
@endpush