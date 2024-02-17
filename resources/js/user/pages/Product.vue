<template>
    <Card class="uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
        <div class="uk-card-media-left uk-cover-container border">
            <img :src="getImg(product.imgPath)" alt="image" uk-cover>
        </div>
        <div class="uk-card-body">
            <h3 class="uk-card-title">{{ product.name }}</h3>
            <p>{{ 'Description: ' + product.description }}</p>
            <p>{{ 'Composition: ' + product.composition }}</p>
            <p>{{ 
                'Fats: ' + product.nutritional.fats + ' ' +
                'Proteins: ' + product.nutritional.proteins + ' ' +
                'Carbohydrates: ' + product.nutritional.carbohydrates
            }}</p>
            <p v-if="productInBasket">{{ product.price * productInBasket.count! }}</p>
            <Button type="primary" @click="productsStore.plus(id)">{{ product.price }}</Button>
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
import { useProductsStore } from '@user/store/products';
import { Product } from '@helpers/interfaces';
import { productById } from '@user/services/api';
import Card from '@components/Card.vue';
import Button from '@components/Button.vue';
import Counter from '@components/Counter.vue';

const productsStore = useProductsStore();

const props = defineProps<{
    id: number
}>()

let data = ref();
productById(props.id).then(response => data.value = response);

const product = computed<Product>(() => data.value);
const productInBasket = computed(() => productsStore.getProductInBasketById(props.id));

const getImg = (path: string): string => (path.slice(0, 4) == 'http') ? path : '../' + path;
</script>