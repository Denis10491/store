<script setup lang="ts">
import {computed} from "vue";
import {findItemById, getImg} from "@helpers/functions";
import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import {Basket} from "@user/modules/product/services/basket";
import {useBasketStore} from "@user/modules/product/store/basket";
import Counter from "@components/Counter.vue";
import Card from "@ui/Card.vue";
import Button from "@ui/Button.vue";

const props = defineProps<{
    product: IProduct
}>()

const basketStore = useBasketStore()
const productInBasket = computed(() => findItemById(basketStore.getList, props.product.id))
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
        <div class="uk-card-body uk-padding-small">
            <h3 class="uk-card-title">{{ product.name }}</h3>
            <p>{{ 'Description: ' + product.description }}</p>
            <p>{{ 'Composition: ' + product.composition }}</p>
            <p>{{
                    'Fats: ' + product.nutritional.fats + ' ' +
                    'Proteins: ' + product.nutritional.proteins + ' ' +
                    'Carbohydrates: ' + product.nutritional.carbohydrates
                }}</p>
            <p v-if="productInBasket">{{ product.price * productInBasket.count! }}</p>
            <Button type="primary" @click="Basket.plus(product.id)">{{ product.price }}</Button>
            <Counter
                v-if="productInBasket"
                class="uk-flex uk-flex-middle"
                :id="product.id"
                :count="productInBasket.count!"
                @plus="Basket.plus(product.id)"
                @minus="Basket.minus(product.id)"
                @remove="Basket.remove(product.id)"
            />
        </div>
    </Card>
</template>

