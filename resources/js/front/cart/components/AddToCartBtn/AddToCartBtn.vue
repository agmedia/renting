<template>
    <div class="cart mb-0 d-flex align-items-center">
        <div class="quantity clearfix">
            <input type="button" value="-" class="minus" @click="subtractQuantity()">
            <input type="text" v-model="quantity" class="qty" />
            <input type="button" value="+" class="plus" @click="addQuantity()">
        </div>
        <button class="btn btn-green" @click="addToCart()">Dodaj u Košaricu</button>
    </div>
</template>

<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                quantity: 1
            }
        },
        mounted() {
        },
        methods: {
            addToCart() {
                let item = {
                    id: this.id,
                    quantity: this.quantity
                }

                this.$store.dispatch('addToCart', item);
            },

            subtractQuantity() {
                if (this.quantity > 1) {
                    this.quantity = this.quantity - 1;
                }
            },

            addQuantity() {
                this.quantity = this.quantity + 1;
            }
        }
    };
</script>
