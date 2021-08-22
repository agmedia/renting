<div class="col-md-4 col-sm-6 px-2 mb-4">
    <div class="card product-card-alt">
        <div class="product-thumb">
            <div class="product-card-actions">
                <a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ $product->url($cat, $subcat) }}"><i class="ci-eye"></i></a>
<!--                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>-->
                <add-to-cart-btn-simple id="{{ $product->id }}"></add-to-cart-btn-simple>
            </div>
            <a class="product-thumb-overlay" href="{{ $product->url($cat, $subcat) }}"></a>
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted fs-xs me-1">
                    @if ($product->author)
                        <a class="product-meta fw-medium" href="{{ $product->author->url() }}">{{ $product->author->title }}</a>
                    @else
                        <a class="product-meta fw-medium" href="#">Nepoznato</a>
                    @endif
                </div>
                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                </div>
            </div>
            <h3 class="product-title fs-sm mb-2"><a href="{{ $product->url($cat, $subcat) }}">{{ $product->name }}</a></h3>
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="fs-sm me-2"><i class="ci-book text-muted"></i> {!! $product->categoriesString($cat, $subcat) !!}</div>
                @if ($product->special())
                    <div class="bg-faded-accent text-accent text-sm rounded-1 py-1 px-2" style="text-decoration: line-through;">{!! $product->priceString() !!}</div>
                    <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">{!! $product->priceString($product->special()) !!}</div>
                @else
                    <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">{!! $product->priceString() !!}</div>
                @endif
            </div>
        </div>
    </div>
    <hr class="d-sm-none">
</div>