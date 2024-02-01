<template>
<div v-if="loaded" class="product-card uk-card uk-card-default uk-padding uk-margin-small-bottom uk-flex uk-width-1-1 border">
    <div class="product-card-img uk-card-media-left uk-cover-container">
        <img :src="imgPath" class="border" alt="image" uk-cover>
    </div>
    <div class="uk-width-1-1 uk-margin-small-left">
        <h3 class="uk-card-title">{{ name }}</h3>
        <p>{{ description }}</p>
        <div v-if="productInBasket" class="product-control uk-flex uk-flex-end uk-flex-middle uk-margin-small-left">
            <p class="uk-margin-small-right">{{ price * productInBasket.count + 'Р' }}</p>
            <div class="uk-flex uk-flex-center uk-flex-middle">
                <button class="uk-button uk-button-default uk-margin-small-right" 
                    @click="productsStore.addToBasket(id, '+', price)">+</button>
                <p>{{ productInBasket.count }}</p>
                <button class="uk-button uk-button-default uk-margin-small-left uk-margin-small-right" 
                    @click="productsStore.addToBasket(id, '-', price)">-</button>
                <button class="uk-button uk-button-danger" 
                    @click="productsStore.removeById(id, price)">Remove</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { useProductsStore } from '../../store/products';

export default {
    name: 'ProductComponent',
    props: [ 'id', 'page', 'isAdmin', 'renderFormProductById' ],

    setup() {
        const productsStore = useProductsStore();
        return { productsStore }
    },

    data() {
        return {
            loaded: false,
            imgPath: "",
            name: "",
            description: "",
            price: NaN
        }
    },

    async created() {
        const product = await this.productsStore.getProductById(this.id);
        this.imgPath = await product.imgPath;
        this.name = await product.name;
        this.description = await product.description;
        this.price = await product.price;
        this.productsStore.sumPriceInBasket += await product.price * this.productInBasket["count"];
        if (await product) this.loaded = true;
    },

    methods: {
        selectThis() {
            this.renderFormProductById({id: this.id})
        }
    },

    computed: {
        productInBasket() {
            return this.productsStore.getProductInBasketById(this.id)
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