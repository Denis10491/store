<template>
    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin border" uk-grid>
        <div class="uk-card-media-left uk-cover-container border">
            <img :src="getImg(product.imgPath)" alt="image" uk-cover>
        </div>
        <div>
            <div class="uk-card-body">
                <h3 class="uk-card-title">{{ product.name }}</h3>
                <p>{{ 'Description: ' + product.description }}</p>
                <p>{{ 'Composition: ' + product.composition }}</p>
                <p>{{ 
                    'Fats: ' + product.nutritional.fats + ' ' +
                    'Proteins: ' + product.nutritional.proteins + ' ' +
                    'Carbohydrates: ' + product.nutritional.carbohydrates
                }}</p>
                <p v-if="productInBasket" >{{ product.price * productInBasket.count + 'Р' }}</p>

                <div class="uk-flex uk-flex-end uk-flex-middle">
                    <button class="uk-button uk-button-primary uk-margin-small-right"
                        v-if="!productInBasket" 
                        @click="productsStore.addToBasket(id, '+')"
                    >{{ product.price + ' Р' }}</button>

                    <button class="uk-button uk-button-primary uk-margin-small-right" 
                        v-else
                        @click="productsStore.addToBasket(id, '+')"
                    >{{ product.price + 'Р' }}</button>

                    <div class="uk-flex uk-flex-center uk-flex-middle" v-if="productInBasket">
                        <button class="uk-button uk-button-default uk-margin-small-right" @click="productsStore.addToBasket(id, '+')">+</button>
                        <p>{{ productInBasket.count }}</p>
                        <button class="uk-button uk-button-default uk-margin-small-left" @click="productsStore.addToBasket(id, '-')">-</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { Product } from '../../helpers/interfaces';
import { productById } from '../services/api';
import { useProductsStore } from '../store/products';

const productsStore = useProductsStore()

interface Props {
    id: string| number
}
const props = defineProps<Props>()

let data = ref();
productById(props.id).then(response => data.value = response);

const product = computed<Product>(() => data.value);
const productInBasket = computed(() => productsStore.getProductInBasketById(props.id));

const getImg = (path: string): string => (path.slice(0, 4) == 'http') ? path : '../' + path;
</script>