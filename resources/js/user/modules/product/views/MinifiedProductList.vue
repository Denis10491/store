<script setup lang="ts">
import ProductItem from "@user/modules/product/components/ProductItem.vue";
import {useProductsStore} from "@user/modules/product/store/product";
import {computed} from "vue";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";

const productsStore = useProductsStore();
const products = computed<Array<IMinifiedProduct>>(() => productsStore.getList);
</script>

<template>
    <div
        v-if="products.length > 0"
        class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-text-center uk-width-1-1 uk-height-1-1"
        uk-grid="masonry: pack"
    >
        <div v-for="(product, key) in products" :key="key">
            <ProductItem
                :id="product.id"
                :name="product.name"
                :price="product.price"
                :img_path="product.img_path"
            />
        </div>
    </div>
    <h2 v-else>Loading...</h2>
</template>

<style scoped>

</style>
