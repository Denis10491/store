<script setup lang="ts">
import {ref} from "vue";
import ProductCard from "@user/modules/product/views/ProductCard.vue";
import ReviewList from "@user/modules/product/views/ReviewList.vue";
import {Product} from "@user/modules/product/services/product";
import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import Card from "@ui/Card.vue";

const props = defineProps<{ id: number }>()

let product = ref<IProduct>()
Product.getById(props.id).then(data => product.value = data)
</script>

<template>
    <div>
        <ProductCard :product="product"/>

        <Card>
            <h2>Отзывы</h2>
            <ReviewList :reviews="product!.reviews"/>
        </Card>
    </div>
</template>
