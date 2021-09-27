<template>
    <section class="col-lg-8">
        <!-- Toolbar-->
        <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
            <div class="d-flex flex-wrap">
                <div class="dropdown me-2 d-sm-none"><a class="btn btn-primary dropdown-toggle collapsed" href="#shop-sidebar" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-filter-alt"></i></a></div>
                <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                    <label class="text-light opacity-75 text-nowrap fs-sm me-2 d-none d-sm-block" for="sorting"></label>
                    <select class="form-select" id="sorting-select">
                        <option value="" selected>Sortiraj</option>
<!--                        @foreach (config('settings.sorting_list') as $item)
                        <option value="{{ $item['value'] }}" @if(request()->get('sort') == $item['value']) selected @endif>{{ $item['title'] }}</option>
                        @endforeach-->
                    </select>
                </div>
            </div>
            <!--  <div class="d-flex pb-3"><a class="nav-link-style nav-link-light me-3" href="#"><i class="ci-arrow-left"></i></a><span class="fs-md text-light">{{ $products->currentPage() }} / {{ $products->lastPage() }}</span><a class="nav-link-style nav-link-light ms-3" href="#"><i class="ci-arrow-right"></i></a></div>-->

            <div class="d-flex pb-3">  <span class="fs-sm text-light btn btn-primary btn-sm text-nowrap ms-2 d-none d-sm-block">Ukupno ... artikala</span></div>


        </div>
        <!-- Products grid-->
        <div class="row mx-n2">
            <div class="col-md-4 col-6 px-2 mb-4" v-for="product in products">
                <div class="card product-card-alt">
                    <div class="product-thumb">
                        <div class="product-card-actions">
                            <a class="btn btn-light btn-icon btn-shadow fs-base mx-2" :href="product.url"><i class="ci-eye"></i></a>
                            <button type="button" class="btn btn-light btn-icon btn-shadow fs-base mx-2" v-on:click="add(product.id)"><i class="ci-cart"></i></button>
                        </div>
                        <a class="product-thumb-overlay" :href="product.url"></a>
                        <img load="lazy" :src="product.image.replace('.webp', '-thumb.webp')" width="250" height="300" :alt="product.name">
                    </div>
                    <div class="card-body pt-2">
                        <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                            <div class="text-muted fs-xs me-1">
                                <a class="product-meta fw-medium" :href="product.author.url">{{ product.author.title }}</a>
                            </div>

                        </div>
                        <h3 class="product-title fs-sm mb-0"><a :href="product.url">{{ product.name }}</a></h3>
<!--                        @if ($product->category_string)
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="fs-sm me-2"><i class="ci-book text-muted" style="font-size: 11px;"></i> {!! $product->category_string !!}</div>
                        </div>
                        @endif
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-2">
                            @if ($product->special())
                            <div class="bg-faded-accent text-accent text-sm rounded-1 py-1 px-2" style="text-decoration: line-through;">{!! $product->priceString() !!}</div>
                            <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">{!! $product->priceString($product->special()) !!}</div>
                            @else
                            <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">{!! $product->priceString() !!}</div>
                            @endif
                        </div>-->
                    </div>
                </div>
                <hr class="d-sm-none">
            </div>
        </div>

        <hr class="my-3">


    </section>
</template>

<script>
    export default {
        name: 'ProductsList',
        props: {
            group: String,
            cat: String,
            subcat: String,
            author: String,
            publisher: String,
            //buttons: {type: String, default: 'true'},
        },
        //
        data() {
            return {
                products: [],
            }
        },
        //
        watch: {
            $route(params) {
                console.log('params')
                console.log(params)
            }
        },
        //
        mounted() {
            this.getProducts();

            console.log(location)
        },

        methods: {
            getProducts() {
                let params = {
                    group: this.group,
                    cat: this.cat,
                    subcat: this.subcat,
                    author: this.author,
                    publisher: this.publisher,
                };

                axios.post('filter/getProducts', { params }).then(response => {
                    this.products = response.data.data;

                    console.log(response.data)
                });
            },

            add(id) {
                this.$store.dispatch('addToCart', {
                    id: id,
                    quantity: 1
                });
            }
        }
    };
</script>


<style>

</style>
