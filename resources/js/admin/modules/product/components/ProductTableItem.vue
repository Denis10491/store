<script setup lang="ts">
import {Product} from "@admin/modules/product/services/product";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import Button from "@ui/Button.vue";
import { getImg } from "@helpers/functions";

const props = defineProps<IMinifiedProduct>()

const update = async () => {
    const product = await Product.getById(props.id)
    Product.store.selectedProduct = product
}

const remove = async () => {
    await Product.delete(props.id)
}
</script>

<template>
    <tr class="uk-height-1-1">
        <td>{{ props.id }}</td>
        <th class="uk-align-center">
            <img :src="getImg(props.img_path)" alt="">
        </th>
        <td>{{ props.name }}</td>
        <td>{{ props.price }}</td>
        <td>{{ props.amount }}</td>
        <td class="uk-align-center">
            <a uk-toggle href="#update-product" @click="update()">
                <Button type="primary">Update</Button>
            </a>
            <Button type="danger" @click="remove()" class="uk-margin-small-left">Remove</Button>
        </td>
    </tr>
</template>

<style>
img {
    height: 50px;
}
</style>