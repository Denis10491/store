<script setup lang="ts">
import {Product} from "@admin/modules/product/services/product";
import {useProductStore} from "@admin/modules/product/store/product";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
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
    <tr class="uk-height-1-1">
        <td>{{ props.id }}</td>
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
