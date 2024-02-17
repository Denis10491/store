<template>
    <div 
        v-if="loaded" 
        class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-text-center uk-width-1-1 uk-height-1-1"
        uk-grid="masonry: pack"
    >
        <div v-for="(product, key) in products[currentPage]" :key="key">
            <ProductCard 
                :id="product.id"
                :name="product.name"
                :description="product.description"
                :price="product.price"
                :imgPath="product.imgPath"
            />
        </div>
    </div>
    <h2 v-else>Loading...</h2>

    <Paginator
        class="uk-margin-top"
        :currentPage="currentPage"
        :numOfMaxPage="productsStore.getLastPage"
        @changePage="changePage"
    />
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useProductsStore } from '@user/store/products';
import { ArrayProduct } from '@helpers/interfaces';
import ProductCard from '@user/components/products/ProductCard.vue';
import Paginator from '@components/Paginator.vue';

const productsStore = useProductsStore();

const loaded = ref<boolean>(false);
const currentPage = ref<number>(1);

const changePage = (num: number) => {
    loaded.value = false;
    productsStore.getPage(num);
    setTimeout(() => {
        productsStore.getLastPage < num
        ? currentPage.value = productsStore.getLastPage
        : currentPage.value = num;
        loaded.value = true;
    }, 500);
}
changePage(1);

const products = computed<ArrayProduct>(() => productsStore.getList);
</script>