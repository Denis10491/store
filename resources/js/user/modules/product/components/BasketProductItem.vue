<script setup lang="ts">
import {Basket} from "@user/modules/product/services/basket";
import Card from '@ui/Card.vue';
import Counter from '@components/Counter.vue';
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";

const props = defineProps<IMinifiedProduct>()
</script>

<template>
    <Card v-if="props.id" class="uk-flex uk-width-1-1 uk-margin-small-bottom">
        <div class="img uk-card-media-left uk-cover-container">
            <img :src="props.img_path" class="border" alt="image" uk-cover>
        </div>
        <div class="uk-width-1-1 uk-margin-small-left">
            <h3 class="uk-card-title">{{ props.name }}</h3>
            <p class="uk-margin-small-right">{{ props.price * props.count! }}</p>
            <Counter
                class="uk-flex uk-flex-middle"
                :id="id"
                :count="props.count!"
                @plus="Basket.plus(id)"
                @minus="Basket.minus(id)"
                @remove="Basket.remove(id)"
            />
        </div>
    </Card>
</template>

<style scoped>
.img {
    width: 200px;
    height: 100%;
}
</style>
