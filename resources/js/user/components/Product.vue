<template>
<div v-if="data" class="product-card uk-card uk-card-default uk-padding uk-margin-small-bottom uk-flex uk-width-1-1 border">
    <div class="product-card-img uk-card-media-left uk-cover-container">
        <img :src="data.imgPath" class="border" alt="image" uk-cover>
    </div>
    <div class="uk-width-1-1 uk-margin-small-left">
        <h3 class="uk-card-title">{{ data.name }}</h3>
        <p>{{ data.description }}</p>

        <div class="product-control uk-flex uk-flex-end uk-flex-middle uk-margin-small-left" 
            v-if="productInBasket"
        >
            <p class="uk-margin-small-right">{{ data.price * productInBasket.count + 'Р' }}</p>

            <div class="uk-flex uk-flex-center uk-flex-middle">
                <button class="uk-button uk-button-default uk-margin-small-right" 
                    @click="productsStore.addToBasket(data.id, '+')">+</button>
                <p>{{ productInBasket.count }}</p>
                <button class="uk-button uk-button-default uk-margin-small-left uk-margin-small-right" 
                    @click="productsStore.addToBasket(data.id, '-')">-</button>
                <button class="uk-button uk-button-danger" 
                    @click="productsStore.removeById(data.id)">Remove</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { useProductsStore } from '../store/products';

export default {
    name: 'ProductComponent',
    props: [ 'data', 'page', 'isAdmin', 'renderFormProductById' ],

    setup() {
        const productsStore = useProductsStore();
        return { productsStore }
    },

    methods: {
        selectThis() {
            this.renderFormProductById({id: this.data.id})
        }
    },

    computed: {
        productInBasket() {
            return this.productsStore.getProductInBasketById(this.data.id)
        }
    }
}
</script>

<style scoped>
.product-card-img {
    width: 200px;
    height: 100%;
}
.product-control {
    height: auto;
}
.product-control p {
    margin: 0;
}
span {
    font-weight: 900;
}
</style>