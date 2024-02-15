<template>
<Card v-if="loaded" class="uk-flex uk-width-1-1 uk-margin-small-bottom">
    <div class="img uk-card-media-left uk-cover-container">
        <img :src="imgPath" class="border" alt="image" uk-cover>
    </div>
    <div class="uk-width-1-1 uk-margin-small-left">
        <h3 class="uk-card-title">{{ name }}</h3>
        <p>{{ description }}</p>
        <p class="uk-margin-small-right">{{ price * productInBasket.count! }}</p>
        <Counter v-if="productInBasket"
            class="uk-flex uk-flex-middle"
            :id="id"
            :count="productInBasket.count!"
            @plus="productsStore.plus(id)"
            @minus="productsStore.minus(id)"
            @remove="productsStore.removeById(id)"
        />
    </div>
</Card>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useProductsStore } from '../../store/products';
import Card from '../../../components/Card.vue';
import Counter from '../../../components/Counter.vue';
import { productById } from '../../services/api';

const props = defineProps<{
    id: number
}>();

const productsStore = useProductsStore();
const productInBasket = computed(() => productsStore.getProductInBasketById(props.id));

const loaded = ref<boolean>(false);
const imgPath = ref<string>('');
const name = ref<string>('');
const description = ref<string>('');
const price = ref<number>(NaN);

const loadProduct = (): void => {
    productById(props.id).then(product => {
        imgPath.value = product.imgPath;
        name.value = product.name;
        description.value = product.description;
        price.value = product.price;
        productsStore.sumPriceInBasket += product.price * productInBasket.count ?? 1;
        loaded.value = true;
    });
}
loadProduct();
</script>

<style scoped>
.img {
    width: 200px;
    height: 100%;
}
</style>