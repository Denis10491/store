<script setup lang="ts">
import type {IReview} from "@user/modules/product/interfaces/IReview";
import ReviewItem from "@user/modules/product/components/ReviewItem.vue";

defineProps<{
    reviews: Array<IReview>
}>()
</script>

<template>
    <div v-for="(review, idx) in reviews" :key="idx">
        <ReviewItem :review="review"/>
        <hr>
    </div>
</template>
