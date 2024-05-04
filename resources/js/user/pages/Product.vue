<script setup lang="ts">
import {computed, ref} from "vue";
import ProductCard from "@user/modules/product/views/ProductCard.vue";
import ReviewList from "@user/modules/product/views/ReviewList.vue";
import CreateReviewForm from "@user/modules/product/views/CreateReviewForm.vue";
import {Product} from "@user/modules/product/services/product";
import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import type {IReview} from "@user/modules/product/interfaces/IReview";
import Card from "@ui/Card.vue";

const props = defineProps<{ id: number }>()

let product = ref<IProduct>()
Product.getById(props.id).then(data => product.value = data)

const reviews = computed<Array<IReview>>(() => product.value!.reviews.reverse())

const addReview = (review: IReview): void => {
    product.value!.reviews.reverse().push(review)
}
</script>

<template>
    <div>
        <ProductCard :product="product"/>

        <Card>
            <h2>Отзывы</h2>
            <CreateReviewForm :product="product" @addReview="addReview"/>
            <ReviewList :reviews="reviews"/>
        </Card>
    </div>
</template>
