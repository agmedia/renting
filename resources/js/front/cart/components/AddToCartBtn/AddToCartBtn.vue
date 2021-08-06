<template>
    <div class="cart mb-0 d-flex align-items-center">
        <div class="quantity clearfix">
            <input type="button" value="-" class="minus" @click="subtractQuantity()">
            <input type="text" v-model="qty" class="qty" style="width: 36px;" />
            <input type="button" value="+" class="plus" @click="addQuantity()">
        </div>
        <button class="btn btn-primary btn-shadow d-block w-100" @click="addToCart()">Dodaj u Košaricu</button>
    </div>

<!--    <div class="mb-3 d-flex align-items-center">
        <select class="form-select me-3" style="width: 5rem;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <a class="btn btn-primary btn-shadow d-block w-100" href="{{ route('kosarica') }}"><i class="ci-cart fs-lg me-2"></i>Dodaj u košaricu</a>
    </div>-->
</template>

<script>
    export default {
        props: {
            id: String,
            qty: Number
        },

        mounted() {},

        methods: {
            addToCart() {
                let item = {
                    id: this.id,
                    quantity: this.qty
                }

                this.$store.dispatch('addToCart', item);
            },

            subtractQuantity() {
                if (this.qty > 1) {
                    this.qty = this.qty - 1;
                }
            },

            addQuantity() {
                this.qty = this.qty + 1;
            }
        }
    };
</script>
