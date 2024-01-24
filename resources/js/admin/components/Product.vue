<template>
<div class="product-card uk-card uk-card-default uk-padding uk-margin-small-bottom uk-flex uk-width-1-1 border" v-if="data">
    <div class="product-card-img uk-card-media-left uk-cover-container">
        <img :src="getImg(data.imgPath)" class="border" alt="image" uk-cover>
    </div>
    <div class="uk-width-1-1 uk-margin-left">
        <h3 class="title">{{ data.name }}</h3>
        <p><span>Description: </span>{{ data.description }}</p>
        <p><span>Composition: </span>{{ data.composition }}</p>
        <div class="nutritional-list uk-flex uk-flex-middle">
            <p><span>Proteins: </span>{{ data.nutritional.proteins }}</p>
            <p class="uk-margin-small-left"><span>Fats: </span>{{ data.nutritional.fats }}</p>
            <p class="uk-margin-small-left"><span>Carbohydrates: </span>{{ data.nutritional.carbohydrates }}</p>
        </div>
        <p class="uk-margin-small-bottom"><span>Price: </span>{{ data.price }}</p>
        <button class="uk-button uk-button-primary" @click="selectThis()">Update</button>
        <button class="uk-button uk-button-danger uk-margin-small-left" @click="productsStore.deleteFromDB(data.id, page)">Remove</button>
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
        },

        getImg(path) {
            return (path.substr(0, 7) == 'storage') ? '../'+path : path;
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
.nutritional-list p {
    margin: 0;
}
.product-card-img {
    width: 320px;
    height: 100%;
}
span {
    font-weight: 900;
}
</style>