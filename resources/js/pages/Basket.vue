<template>
<div class="basket-cards uk-flex justify-between" v-if="Object.keys(productsInBasket).length > 0">
    <div class="uk-flex uk-flex-column">
        <div class="uk-grid-collapse" v-for="product in productsInBasket" :key="product.id" uk-grid>
            <Product :data=productsStore.getProductById(product.id) />
        </div>
    </div>

    <form class="uk-card uk-card-default uk-flex uk-flex-column uk-margin-small-left uk-padding-small uk-width-1-2 uk-height-1-1"
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
<h2 class="uk-card uk-card-default uk-padding uk-width-auto" v-else>Basket is empty</h2>
</template>

<script>
import { useProductsStore } from '../store/products';
import { useOrdersStore } from '../store/orders'
import Product from '../components/Product.vue';

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
        const productsStore = useProductsStore()
        const ordersStore = useOrdersStore()
        return { productsStore, ordersStore }
    },

    computed: {
        products() {
            return this.productsStore.list ?? [];
        },
        productsInBasket() {
            return this.productsStore.listInBasket ?? {};
        },
        sum() {
            let sumOfproductsInBasket = 0;
            Object.keys(this.productsStore.listInBasket).map(id => {
                this.productsStore.list.forEach(page => {
                    page.forEach(product => {
                        if (product.id == id) sumOfproductsInBasket += product.price * this.productsStore.listInBasket[id]["count"];
                    });  
                });
            });
            return sumOfproductsInBasket;
        }
    },

    methods: {
        async order() {
            const response = await this.ordersStore.create(this.productsInBasket, this.address);
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