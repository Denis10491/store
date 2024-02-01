<template>
<div v-if="Object.keys(productsInBasket).length > 0" class="basket-cards uk-flex justify-between">
    <div class="uk-flex uk-flex-column">
        <div class="uk-grid-collapse" v-for="product in productsInBasket" :key="product.id" uk-grid>
            <Product :id="product.id" />
        </div>
    </div>

    <form class="uk-card uk-card-default uk-flex uk-flex-column uk-margin-small-left uk-padding uk-width-1-2 uk-height-1-1 border"
        @submit.prevent="order()"
    >
        <h3>Оформление заказа</h3>
        <div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Address" v-model="address">
        </div>
        <div class="uk-flex uk-flex-end uk-flex-middle">
            <button class="uk-button uk-button-primary">Buy</button>
            <p class="uk-margin-small-left">{{ sum + ' Р' }}</p>
        </div>
        <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
            <p>We were unable to place your order. Try later</p>
        </div>
    </form>
</div>
<h2 v-else class="uk-card uk-card-default uk-padding uk-width-auto border">Basket is empty</h2>
</template>

<script>
import { createOrder } from '../services/api';
import { useProductsStore } from '../store/products';
import Product from '../components/products/Product.vue';
import { useUserStore } from '../store/user';

export default {
    name: 'basketPage',
    components: { Product },

    data() {
        return {
            address: "",
            isFormRequestStatus: true
        }
    },

    setup() {
        const productsStore = useProductsStore();
        const userStore = useUserStore();
        return { productsStore, userStore }
    },

    computed: {
        products() {
            return this.productsStore.getList ?? [];
        },
        productsInBasket() {
            return this.productsStore.getListInBasket ?? {};
        },
        sum() {
            return this.productsStore.sumPriceInBasket ?? 0;
        }
    },

    methods: {
        async order() {
            if (!this.userStore.isAuth) window.location.href = '/login';
            const response = await createOrder(this.productsInBasket, this.address);
            if (!response) this.isFormRequestStatus = false
            else window.location.href = '/profile'
        }
    }
}
</script>

<style scoped>
.basket-cards h3, 
.basket-cards p {
    margin: 0 0 6px;
}
</style>