<script setup lang="ts">
import {computed, ref} from "vue";
import {findItemById, getImg} from "@helpers/functions";
import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import {Basket} from "@user/modules/product/services/basket";
import {Product} from "@user/modules/product/services/product";
import {useBasketStore} from "@user/modules/product/store/basket";
import Counter from "@components/Counter.vue";
import Card from "@ui/Card.vue";
import Button from "@ui/Button.vue";

const props = defineProps<{ id: number }>()

let product = ref<IProduct>()
Product.getById(props.id).then(data => product.value = data)

const basketStore = useBasketStore()
const productInBasket = computed(() => findItemById(basketStore.getList, props.id))
</script>

<template>
    <Card
        v-if="product"
        class="uk-grid-collapse uk-child-width-1-2@s uk-margin"
        uk-grid
    >
        <div class="uk-card-media-left uk-cover-container border">
            <img :src="getImg(product.img_path ?? '')" alt="image" uk-cover>
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
            <Button type="primary" @click="Basket.plus(id)">{{ product.price }}</Button>
            <Counter
                v-if="productInBasket"
                class="uk-flex uk-flex-middle"
                :id="id"
                :count="productInBasket.count!"
                @plus="Basket.plus(id)"
                @minus="Basket.minus(id)"
                @remove="Basket.remove(id)"
            />
        </div>
    </Card>
</template>

<style scoped>

</style>
