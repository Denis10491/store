<script setup lang="ts">
import {computed} from "vue";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";
import {Basket} from "@user/modules/product/services/basket";
import {useBasketStore} from "@user/modules/product/store/basket";
import {findItemById} from "@helpers/functions";
import Card from '@ui/Card.vue';
import Button from '@ui/Button.vue';
import Counter from "@components/Counter.vue";

const props = defineProps<IMinifiedProduct>()

const basketStore = useBasketStore()

const productInBasket = computed(() => findItemById(basketStore.getList, props.id))
</script>

<template>
    <Card
        class="uk-card-secondary uk-card-body uk-card-hover uk-background-cover"
        uk-scrollspy="cls: uk-animation-fade; delay: 100;"
        :data-src="img_path"
        uk-img
    >
        <h3 class="uk-card-title">{{ name }}</h3>
        <Button type="primary" @click="Basket.plus(id)">{{ price }}</Button>
        <Counter v-if="productInBasket"
                 class="counter"
                 :id="id"
                 :count="productInBasket.count!"
                 @plus="Basket.plus(id)"
                 @minus="Basket.minus(id)"
                 @remove="Basket.remove(id)"
        />
        <router-link :to="'/product/' + id">
            <Button type="default" class="uk-margin-small-left uk-margin-small-top">Подробнее</Button>
        </router-link>
    </Card>
</template>

<style scoped>
@media screen and (max-width: 1280px) {
    .counter {
        flex-direction: column;
    }
}
</style>
