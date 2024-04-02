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
import {computed, ref} from 'vue';
import {useProductsStore} from '@user/store/products';
import {productById} from '@user/services/api';
import Card from '@ui/Card.vue';
import Counter from '@components/Counter.vue';

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
