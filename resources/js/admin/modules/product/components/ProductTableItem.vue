<script setup lang="ts">
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import Button from "@ui/Button.vue";
import {Product} from "@admin/modules/product/services/product";
import {useProductStore} from "@admin/modules/product/store/product";

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
        <td class="uk-align-center">
            <a uk-toggle href="#open-form-product" @click="update()">
                <Button type="primary">Update</Button>
            </a>
            <Button type="danger" @click="remove()">Remove</Button>
        </td>
    </tr>
</template>
