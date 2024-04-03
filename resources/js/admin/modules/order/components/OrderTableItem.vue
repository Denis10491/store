<script setup lang="ts">
import {getPriceOfProducts} from "@helpers/functions";
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";

defineProps<IOrder>()
</script>

<template>
    <tr>
        <td>{{ id }}</td>
        <td>{{ address }}</td>
        <td>
            <p v-for="product in products" :key="product.id">
                {{ product.name + ' x' + product.count + ' (' + product.price + ')' }}</p>
        </td>
        <td>{{ getPriceOfProducts(products!) }}</td>
        <td>{{ created_at!.toString().slice(0, 10).split('-').join('.') }}</td>
    </tr>
</template>

<style scoped>

</style>
