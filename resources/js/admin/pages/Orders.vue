<script setup lang="ts">
import {computed} from 'vue';
import {useOrderStore} from "@admin/modules/order/store/order";
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import OrderTable from "@admin/modules/order/views/OrderTable.vue";
import {Order} from "@admin/modules/order/services/order";
import Card from "@ui/Card.vue";

Order.getAll()
const orderStore = useOrderStore()
const orders = computed<Array<IOrder>>(() => orderStore.getList)
</script>

<template>
    <OrderTable
        v-if="orders.length > 0"
        :orders="orders"
    />
    <Card v-else>Loading...</Card>
</template>

<style>
.filter input {
    width: 160px;
    display: flex;
    align-items: center;
}

.filter button {
    margin: 0 !important;
}

.order-card h3, div, p {
    margin: 0;
    letter-spacing: 1.2px;
}

.order-title > * {
    margin: 0 10px 0 0;
}

.uk-table th {
    text-align: start;
}
</style>
