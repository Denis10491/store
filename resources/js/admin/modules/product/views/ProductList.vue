<script setup lang="ts">
import {computed} from "vue";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import MinifiedProductItem from "@admin/modules/product/components/MinifiedProductItem.vue";
import {useProductStore} from "@admin/modules/product/store/product";

const productsStore = useProductStore()
const products = computed<Array<IMinifiedProduct>>(() => productsStore.getList)
</script>

<template>
    <div v-for="(product, key) in products" :key="key" class="uk-width-1-1" uk-grid>
        <MinifiedProductItem
            :id="product.id"
            :img_path="product.img_path"
            :name="product.name"
            :price="product.price"
        />
    </div>
</template>
