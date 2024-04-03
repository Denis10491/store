<script setup lang="ts">
import {ref} from "vue";
import type {IOrder} from "@user/modules/order/interfaces/IOrder";
import {Order} from "@user/modules/order/services/order";
import OrderItem from "@user/modules/order/components/OrderItem.vue";

let orders = ref()
Order.getAll().then((data: Array<IOrder>) => orders.value = data)
</script>

<template>
    <table v-if="orders" class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Address</th>
            <th>Products</th>
            <th>Price</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <OrderItem
            v-for="(order, key) in orders" :key="key"
            :id="order.id"
            :address="order.address"
            :products="order.products"
            :created_at="order.created_at"
        />
        </tbody>
    </table>
</template>
