<template>
    <div class="navbar-tool dropdown ms-1"><a class="navbar-tool-icon-box bg-secondary dropdown-toggle" :href="carturl"><span class="navbar-tool-label">{{ $store.state.cart ? $store.state.cart.count : 0 }}</span><i class="navbar-tool-icon ci-cart"></i></a>
        <!-- Cart dropdown-->
        <div class="dropdown-menu dropdown-menu-end">
            <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;" v-if="$store.state.cart.count">
                <div style="height: 5rem;" data-simplebar-auto-hide="false" v-for="item in $store.state.cart.items">
                    <div class="widget-cart-item pb-2 border-bottom">
                        <button class="btn-close text-danger" type="button" @click.prevent="removeFromCart(item)" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                        <div class="d-flex align-items-center"><a class="d-block" href="#"><img :src="item.associatedModel.image" :alt="item.name" :title="item.name" width="64"></a>
                            <div class="ps-2">
                                <h6 class="widget-product-title"><a :href="base_path + item.attributes.path">{{ item.name }}</a></h6>
                                <div class="widget-product-meta"><span class="text-accent me-2">{{ Object.keys(item.conditions).length ? $store.state.service.formatPrice(item.price - item.conditions.parsedRawValue) : $store.state.service.formatPrice(item.price) }}</span><span class="text-muted">x {{ item.quantity }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                    <div class="fs-sm me-2 py-2"><span class="text-muted">Ukupno:</span><span class="text-accent fs-base ms-1">{{ $store.state.service.formatPrice($store.state.cart.total) }}</span></div><a class="btn btn-outline-secondary btn-sm" :href="carturl">Košarica<i class="ci-arrow-right ms-1 me-n1"></i></a>
                </div><a class="btn btn-primary btn-sm d-block w-100" :href="carturl"><i class="ci-card me-2 fs-base align-middle"></i>Dovrši kupnju</a>
            </div>
            <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;" v-else>
                <i class="fa fa-cart-arrow-down fa-2x" style="color: #aaaaaa"></i>
                <p>Vaša košarica je prazna!</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            carturl: String,
            checkouturl: String
        },
        //
        data() {
            return {
                base_path: window.location.origin + '/',
                success_path: window.location.origin + '/kosarica/success',
                mobile: false
            }
        },
        //
        mounted() {
            this.getCart();

            if (window.location.pathname == '/kosarica/success') {
                this.$store.dispatch('flushCart');
            }

            if (window.innerWidth < 800) {
                this.mobile = true;
            }
        },
        //
        methods: {
            //
            getCart() {
                this.$store.dispatch('getCart')
            },
            //
            removeFromCart(item) {
                this.$store.dispatch('removeFromCart', item);
            }
        }
    };
</script>
