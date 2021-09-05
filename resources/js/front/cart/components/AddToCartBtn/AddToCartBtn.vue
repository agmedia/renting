<template>
    <div class="cart mb-5 d-flex align-items-center">
        <div class="quantity clearfix">
         <!--   <input type="button" value="-" class="minus" @click="subtractQuantity()">-->
            <input type="hidden" v-model="qty" class="qty"  />
         <!--   <input type="button" value="+" class="plus" @click="addQuantity()"> -->
        </div>
        <button class="btn btn-primary btn-shadow d-block w-100" @click="addToCart()">Dodaj u Košaricu</button>
    </div>
</template>

<script>
export default {
    props: {
        id: String,
        qty: 1
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
