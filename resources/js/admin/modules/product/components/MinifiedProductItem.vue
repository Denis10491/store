<script setup lang="ts">
import {getImg} from "@helpers/functions";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import {useProductStore} from "@admin/modules/product/store/product";
import {Product} from "@admin/modules/product/services/product";
import Button from "@ui/Button.vue";

const props = defineProps<IMinifiedProduct>()

const productStore = useProductStore()

const update = async () => {
    productStore.selectedId = props.id
}

const remove = async () => {
    await Product.delete(props.id)
}
</script>

<template>
    <div class="product-card uk-card uk-card-default uk-padding uk-margin-small-bottom uk-flex uk-width-1-1 border">
        <div class="product-card-img uk-card-media-left uk-cover-container">
            <img :src="getImg(props.img_path)" class="border" alt="image" uk-cover>
        </div>
        <div class="uk-width-1-1 uk-margin-left">
            <h3 class="title">{{ props.name }}</h3>
            <p class="uk-margin-small-bottom"><span>Price: </span>{{ props.price }}</p>
            <a href="#open-form-product" uk-toggle @click="update()">
                <Button type="primary">Update</Button>
            </a>
            <Button type="danger" @click="remove()">Remove</Button>
        </div>
    </div>
</template>

<style scoped>
.nutritional-list p {
    margin: 0;
}

.product-card-img {
    width: 320px;
    height: 100%;
}

span {
    font-weight: 900;
}
</style>
