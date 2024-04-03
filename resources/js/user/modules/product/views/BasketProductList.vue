<script setup lang="ts">
import BasketProductItem from "@user/modules/product/components/BasketProductItem.vue";
import {useBasketStore} from "@user/modules/product/store/basket";

const basketStore = useBasketStore()
</script>

<template>
    <div class="basket-cards uk-flex uk-flex-column uk-width-1-1">
        <div class="uk-grid-collapse" v-for="product in basketStore.getList" :key="product.id" uk-grid>
            <BasketProductItem
                :id="product.id"
                :img_path="product.img_path"
                :name="product.name"
                :price="product.price"
                :count="product.count"
            />
        </div>
    </div>
</template>

<style scoped>
.basket-cards h3,
.basket-cards p {
    margin: 0 0 6px;
}
</style>
