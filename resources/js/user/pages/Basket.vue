<template>
    <div v-if="productsInBasket.length > 0" class="basket-cards uk-flex justify-between">
        <div class="uk-flex uk-flex-column">
            <div class="uk-grid-collapse" v-for="product in productsInBasket" :key="product.id" uk-grid>
                <ProductItem :id="product.id" />
            </div>
        </div>

        <Card class="uk-flex-column uk-margin-small-left uk-width-1-2 uk-height-1-1">
            <h3>Оформление заказа</h3>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Address" v-model="address">
            <div class="uk-flex uk-flex-end uk-flex-middle">
                <Button type="primary" @click="send()">Buy</Button>
                <p class="uk-margin-small-left">{{ sum }}</p>
            </div>
            <Error v-if="!isFormRequestStatus">We were unable to place your order. Try later</Error>
        </Card>
    </div>
    <Card v-else>Basket is empty</Card>
</template>

<script setup lang="ts">
import { createOrder } from '../services/api';
import { useProductsStore } from '../store/products';
import { useUserStore } from '../store/user';
import { Product } from '../../helpers/interfaces';
import { computed, ref } from 'vue';
import Button from '../../components/Button.vue';
import Card from '../../components/Card.vue';
import Error from '../../components/Error.vue';
import ProductItem from '../components/products/ProductItem.vue';

const productsStore = useProductsStore();
const userStore = useUserStore();

const address = ref<string>('');
const isFormRequestStatus = ref<boolean>(true);

const productsInBasket = computed<Array<Product>>(() => {
    console.log(productsStore.getListInBasket)
    return productsStore.listInBasket
});
const sum = computed<number>(() => productsStore.getSumPriceInBasket);

const send = async (): Promise<void> => {
    if (!userStore.isAuth) window.location.href = '/login';
    const response = await createOrder(productsInBasket, address.value);
    if (!response) isFormRequestStatus.value = false
    else window.location.href = '/profile'
}
</script>

<style scoped>
.basket-cards h3, 
.basket-cards p {
    margin: 0 0 6px;
}
</style>