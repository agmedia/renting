<section class="col-lg-8">
    <!-- Toolbar-->
    <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
        <div class="d-flex flex-wrap">

            <div class="dropdown me-2 d-sm-none"><a class="btn btn-primary dropdown-toggle collapsed" href="#shop-sidebar" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-filter-alt"></i></a></div>


            <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                <label class="text-light opacity-75 text-nowrap fs-sm me-2 d-none d-sm-block" for="sorting"></label>
                <select class="form-select" id="sorting-select" wire:ignore>
                    <option value="" selected>Sortiraj</option>
                    @foreach (config('settings.sorting_list') as $item)
                        <option value="{{ $item['value'] }}" @if(request()->get('sort') == $item['value']) selected @endif>{{ $item['title'] }}</option>
                    @endforeach
                </select>

            </div>
        </div>
      <!--  <div class="d-flex pb-3"><a class="nav-link-style nav-link-light me-3" href="#"><i class="ci-arrow-left"></i></a><span class="fs-md text-light">{{ $products->currentPage() }} / {{ $products->lastPage() }}</span><a class="nav-link-style nav-link-light ms-3" href="#"><i class="ci-arrow-right"></i></a></div>-->

        <div class="d-flex pb-3">  <span class="fs-sm text-light opacity-75 text-nowrap ms-2 d-none d-sm-block">Ukupno {{ $products->total() }} artikala</span></div>


    </div>
    <!-- Products grid-->
    <div class="row mx-n2">
        @forelse ($products as $product)
            <div class="col-md-4 col-sm-6  px-2 mb-4">
                @include('front.catalog.category.product')
            </div>
        @empty
            <div class="col-md-12 px-2 mb-4">
                <h2>Nema proizvoda...</h2>
                <hr class="d-sm-none">
            </div>
        @endforelse
    </div>

    {{ $products->paginates(3)->onEachSide(3)->links() }}

    <hr class="my-3">


</section>
