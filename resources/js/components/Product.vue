<template>
<div class="product-card uk-card uk-card-default uk-padding-small uk-margin-small-bottom uk-flex uk-width-1-1" v-if="data">
    <div class="product-card-img uk-card-media-left uk-cover-container">
        <img :src="data.imgPath" alt="image" uk-cover>
    </div>
    <div class="uk-width-1-1 uk-margin-small-left">
        <div v-if="isAdmin">
            <h3 class="title">{{ data.name }}</h3>
            <p><span>Description: </span>{{ data.description }}</p>
            <p><span>Composition: </span>{{ data.composition }}</p>
            <div class="uk-flex">
                <p><span>Proteins: </span>{{ data.nutritional.proteins }}</p>
                <p class="uk-margin-small-left"><span>Fats: </span>{{ data.nutritional.fats }}</p>
                <p class="uk-margin-small-left"><span>Carbohydrates: </span>{{ data.nutritional.carbohydrates }}</p>
            </div>
            <p class="uk-margin-small-bottom"><span>Price: </span>{{ data.price }}</p>
            <button class="uk-button uk-button-primary" @click="selectThis()">Update</button>
            <button class="uk-button uk-button-danger uk-margin-small-left" @click="productsStore.deleteFromDB(data.id)">Remove</button>
        </div>
        <div v-else>
            <h3 class="uk-card-title">{{ data.name }}</h3>
            <p>{{ data.description }}</p>
        </div>

        <div class="product-control uk-flex uk-flex-end uk-flex-middle uk-margin-small-left" 
            v-if="productInBasket && !isAdmin"
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
    props: [ 'data', 'isAdmin', 'renderFormProductById' ],

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