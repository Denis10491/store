<script setup lang="ts">
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import OrderTableItem from "@admin/modules/order/components/OrderTableItem.vue";

defineProps<{
    orders: Array<IOrder>
}>()
</script>

<template>
    <table class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Address</th>
            <th>Products</th>
            <th>Price</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <OrderTableItem
            v-for="(order, key) in orders"
            :key="key"
            :id="order.id"
            :address="order.address"
            :status="order.status"
            :products="order.products"
            :created_at="order.created_at"
        />
        </tbody>
    </table>
</template>

<style scoped>

</style>
