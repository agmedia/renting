<template>
    <div>
        <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1" v-if="show_buttons">
            <h2 class="h6 text-dark mb-0">Artikli</h2><a class="btn btn-secondary btn-sm ps-2" :href="continueurl"><i class="ci-arrow-left me-2"></i>Nastavi kupnju</a>
        </div>
        <!-- Item-->
        <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom" v-for="item in $store.state.cart.items">
            <div class="d-block d-sm-flex align-items-center text-center text-sm-start">
                <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" :href="base_path + item.attributes.path">
                    <img :src="item.associatedModel.image" width="120" :alt="item.name" :title="item.name">
                </a>
                <div class="pt-2">
                    <h3 class="product-title fs-base mb-2"><a :href="base_path + item.attributes.path">{{ item.name }}</a></h3>

                    <div class="fs-lg text-accent pt-2">{{ Object.keys(item.conditions).length ? $store.state.service.formatPrice(item.price - item.conditions.parsedRawValue) : $store.state.service.formatPrice(item.price) }}</div>
                </div>
            </div>
            <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                <label class="form-label">Količina</label>
                <input class="form-control" type="number" v-model="item.quantity" min="1" max="1" value="1" readonly>
                <button class="btn btn-link px-0 text-danger" type="button" @click.prevent="removeFromCart(item)"><i class="ci-close-circle me-2"></i><span class="fs-sm">Ukloni</span></button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            continueurl: String,
            checkouturl: String,
            buttons: {type: String, default: 'true'},
        },
        data() {
            return {
                base_path: window.location.origin + '/',
                mobile: false,
                show_delete_btn: true,
                coupon: '',
                show_buttons: true,
            }
        },
        mounted() {
            if (window.innerWidth < 800) {
                this.mobile = true;
            }

            if (this.buttons == 'false') {
                this.show_buttons = false;
            } else {
                this.show_buttons = true;
            }

            this.checkIfEmpty();
            this.setCoupon();

            if (window.location.pathname == '/kosarica/naplata') {
                this.show_delete_btn = false;
            }
        },

        methods: {

            /**
             *
             * @param item
             */
            updateCart(item) {
                this.$store.dispatch('updateCart', item);
            },

            /**
             *
             * @param item
             */
            removeFromCart(item) {
                this.$store.dispatch('removeFromCart', item);
            },

            /**
             *
             * @param qty
             * @returns {number|*}
             * @constructor
             */
            CheckQuantity(qty) {
                if (qty < 1) {
                    return 1;
                }

                return qty;
            },

            /**
             *
             */
            checkIfEmpty() {
                let cart = this.$store.state.storage.getCart();

                if (cart && ! cart.count && window.location.pathname != '/kosarica') {
                    window.location.href = '/kosarica';
                }
            },

            /**
             *
             */
            setCoupon() {
                let cart = this.$store.state.storage.getCart();

                this.coupon = cart.coupon;
            },

            /**
             *
             */
            checkCoupon() {
                this.$store.dispatch('checkCoupon', this.coupon);
            }
        }
    };
</script>


<style>
.table th, .table td {
    padding: 0.75rem 0.45rem !important;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.empty th, .empty td {
    padding: 1rem !important;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.mobile-prices {
    font-size: .66rem;
    color: #999999;
}
</style>
