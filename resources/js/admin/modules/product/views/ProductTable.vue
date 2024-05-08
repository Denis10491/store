<script setup lang="ts">
import ProductTableItem from "@admin/modules/product/components/ProductTableItem.vue";
import {useProductStore} from "@admin/modules/product/store/product";
import {computed} from "vue";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";

const productsStore = useProductStore()
const products = computed<Array<IMinifiedProduct>>(() => productsStore.getList)
</script>

<template>
    <table class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
        <tr>
            <th>№</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Amount</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <ProductTableItem
            v-for="(product, key) in products"
            :key="key"
            :id="product.id"
            :img_path="product.img_path"
            :name="product.name"
            :price="product.price"
            :amount="product.amount"
        />
        </tbody>
    </table>
</template>

<style scoped>
.uk-table th {
    text-align: start;
}
</style>
