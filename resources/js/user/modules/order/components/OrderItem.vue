<script setup lang="ts">
import {getPriceOfProducts} from "@helpers/functions";
import type {IOrder} from "@user/modules/order/interfaces/IOrder";

const props = defineProps<IOrder>()
</script>

<template>
    <tr>
        <td>{{ id }}</td>
        <td>{{ address }}</td>
        <td>
            <p v-for="product in props.products" :key="product.id">
                {{ product.name + ' x' + product.count + ' (' + product.price + ')' }}</p>
        </td>
        <td>{{ getPriceOfProducts(props.products!) }}</td>
        <td>{{ created_at?.toString().slice(0, 10).split('-').join('.') }}</td>
    </tr>
</template>

<style scoped>

</style>
