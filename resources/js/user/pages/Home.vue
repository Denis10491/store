<template>
    <div v-if="loaded" class="uk-child-width-1-2@s uk-child-width-1-3 uk-text-center uk-width-1-1" uk-grid>
        <div v-for="product in products[currentPage]" :key="product.id" uk-img 
            class="uk-card uk-card-secondary uk-card-body uk-card-hover uk-background-cover border"
            uk-scrollspy="cls: uk-animation-fade; delay: 100;"
            :data-src="product.imgPath"
        >
            <h3 class="uk-card-title">{{ product.name }}</h3>
            <p>{{ product.description }}</p>
            <div class="uk-flex uk-flex-center uk-flex-middle">
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
    <h2 class="uk-card uk-card-default uk-padding uk-width-auto border" v-else>Loading...</h2>

    <Paginator
        :currentPage="currentPage"
        :changePage="changePage"
        :numOfMaxPage="productsStore.numOfMaxPage"
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
            loaded: true,
            currentPage: 1
        }
    },

    setup() {
        const productsStore = useProductsStore()
        return { productsStore }
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