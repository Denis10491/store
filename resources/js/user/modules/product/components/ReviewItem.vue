<script setup lang="ts">
import type {IReview} from "@user/modules/product/interfaces/IReview";
import {toDateViewFormat} from "../../../../helpers/functions";

defineProps<{
    review: IReview
}>()
</script>

<template>
    <div>
        <div class="uk-flex uk-flex-middle uk-flex-between">
            <div class="uk-flex uk-flex-middle">
                <h3>{{ review.user_name }}</h3>
                <span v-for="star in review.rating" :key="star" uk-icon="icon: star"></span>
            </div>
            <p>{{ toDateViewFormat(review.created_at) }}</p>
        </div>
        <p>{{ review.body }}</p>
    </div>
</template>

<style scoped>
h3 {
    margin: 0 8px 0 0;
}

span {
    color: var(--clr-yellow);
    margin: 0 2px 0;
}
</style>
