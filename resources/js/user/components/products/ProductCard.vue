<template>
    <Card
        class="uk-card-secondary uk-card-body uk-card-hover uk-background-cover"
        uk-scrollspy="cls: uk-animation-fade; delay: 100;"
        :data-src="imgPath"
        uk-img
    >
        <h3 class="uk-card-title">{{ name }}</h3>
        <p>{{ description }}</p>
        <Button type="primary" @click="productsStore.plus(id)">{{ price }}</Button>
        <Counter v-if="productInBasket"
                 class="counter"
                 :id="id"
                 :count="productInBasket.count!"
                 @plus="productsStore.plus(id)"
                 @minus="productsStore.minus(id)"
                 @remove="productsStore.removeById(id)"
        />
        <router-link :to="'/product/' + id">
            <Button type="default" class="uk-margin-small-left uk-margin-small-top">Подробнее</Button>
        </router-link>
    </Card>
</template>

<script setup lang="ts">
import {computed} from 'vue';
import {useProductsStore} from '@user/store/products';
import Card from '@ui/Card.vue';
import Button from '@ui/Button.vue';
import Counter from '@components/Counter.vue';

const props = defineProps<{
    id: number,
    name: string,
    description: string,
    price: number,
    imgPath: string
}>()

const productsStore = useProductsStore();
const productInBasket = computed(() => productsStore.getProductInBasketById(props.id));
</script>

<style scoped>
@media screen and (max-width: 1280px) {
    .counter {
        flex-direction: column;
    }
}
</style>
