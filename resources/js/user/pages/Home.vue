<template>
<div>
    <div 
        v-if="loaded" 
        class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-text-center uk-width-1-1 uk-height-1-1"
        uk-grid="masonry: pack"
    >
        <div v-for="product in products[currentPage]" :key="product.id">
            <div
                class="uk-card uk-card-secondary uk-card-body uk-card-hover uk-background-cover border"
                uk-scrollspy="cls: uk-animation-fade; delay: 100;"
                :data-src="product.imgPath"
                uk-img
            >
                <h3 class="uk-card-title">{{ product.name }}</h3>
                <p>{{ product.description }}</p>
                <div class="card-control uk-flex uk-flex-center uk-flex-middle">
                    <button class="uk-button uk-button-primary uk-margin-small-right" @click="productsStore.addToBasket(product.id, '+')">{{ product.price + ' Р' }}</button>
                    <div class="uk-flex uk-flex-center uk-flex-middle" v-if="productsInBasket[product.id]">
                        <button class="uk-button uk-button-default uk-margin-small-right" @click="productsStore.addToBasket(product.id, '+')">+</button>
                        <p>{{ productsInBasket[product.id]["count"] }}</p>
                        <button class="uk-button uk-button-default uk-margin-small-left" @click="productsStore.addToBasket(product.id, '-')">-</button>
                    </div>
                </div>
                <router-link :to="'/product/' + product.id" class="uk-button uk-button-default uk-margin-small-left uk-margin-small-top">Подробнее</router-link>
            </div>
        </div>
    </div>
    <h2 class="uk-card uk-card-default uk-padding uk-width-auto border" v-else>Loading...</h2>
</div>

<Paginator
    :currentPage="currentPage"
    :changePage="changePage"
    :numOfMaxPage="productsStore.numOfMaxPage"
    class="uk-margin-top"
/>
</template>

<script>
import { useProductsStore } from '../store/products';
import Paginator from '../../components/Paginator.vue';

export default {
    name: 'HomePage',
    components: { Paginator },

    data() {
        return {
            loaded: false,
            currentPage: 1
        }
    },

    setup() {
        const productsStore = useProductsStore()
        return { productsStore }
    },

    created() {
        this.changePage(1);
    },

    methods: {
        changePage(num) {
            this.loaded = false;
            this.productsStore.getPage(num);
            setTimeout(() => {
                (this.productsStore.numOfMaxPage < num)
                ? this.currentPage = this.productsStore.numOfMaxPage
                : this.currentPage = num;
                this.loaded = true;
            }, 500);
        }
    },

    computed: {
        products() {
            return this.productsStore.list
        },
        productsInBasket() {
            return this.productsStore.listInBasket
        }
    }
}
</script>

<style scoped>
@media screen and (max-width: 1600px) {
    .card-control {
        flex-direction: column;
    }
}
</style>