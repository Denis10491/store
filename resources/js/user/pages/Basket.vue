<script setup lang="ts">
import {useBasketStore} from "@user/modules/product/store/basket";
import BasketProductList from "@user/modules/product/views/BasketProductList.vue";
import CreateOrderForm from "@user/modules/order/views/CreateOrderForm.vue";
import Card from "@ui/Card.vue";

const basketStore = useBasketStore()
</script>

<template>
    <div v-if="basketStore.getList.length > 0" class=" uk-flex justify-between">
        <BasketProductList></BasketProductList>
        <CreateOrderForm/>
    </div>
    <Card v-else>Basket is empty</Card>
</template>
