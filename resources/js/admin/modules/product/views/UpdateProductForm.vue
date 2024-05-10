<script setup lang="ts">
import {computed, ref} from "vue";
import {Product} from "@admin/modules/product/services/product";
import type {ICreateProduct} from "@admin/modules/product/interfaces/ICreateProduct";
import Success from "@components/Success.vue";
import Error from "@components/Error.vue";
import Card from "@ui/Card.vue";
import Textarea from "@ui/Textarea.vue";
import Input from "@ui/Input.vue";
import Button from "@ui/Button.vue";
import type { IProduct } from "../interfaces/IProduct";

const data = ref<ICreateProduct>({
    name: '',
    description: '',
    composition: '',
    fats: NaN,
    proteins: NaN,
    carbohydrates: NaN,
    price: NaN,
    amount: NaN
})
let image = ref<HTMLInputElement | null>()
let isFormRequestStatus = ref<boolean | null>(null)
let message = ref<string>('')

const product = computed<IProduct>(() => {
    data.value.name = Product.store.selectedProduct.name
    data.value.description = Product.store.selectedProduct.description
    data.value.composition = Product.store.selectedProduct.composition
    data.value.fats = Product.store.selectedProduct.nutritional?.fats
    data.value.proteins = Product.store.selectedProduct.nutritional?.proteins
    data.value.carbohydrates = Product.store.selectedProduct.nutritional?.carbohydrates
    data.value.price = Product.store.selectedProduct.price
    data.value.amount = Product.store.selectedProduct.amount

    return Product.store.selectedProduct
})

const updateDescription = (event: InputEvent) => {
    if (event.target) {
        data.value.description = event.target.value
    }
}
const updateComposition = (event: InputEvent) => {
    if (event.target) {
        data.value.composition = event.target.value
    }
}

const submit = async () => {
    const formData: FormData = new FormData()

    if (image.value?.files) {
        formData.append('image', image.value.files[0])
    }

    formData.append('_method', 'PATCH');
    formData.append('name', data.value.name)
    formData.append('description', data.value.description)
    formData.append('composition', data.value.composition)
    formData.append('fats', parseInt(data.value.fats))
    formData.append('proteins', parseInt(data.value.proteins))
    formData.append('carbohydrates', parseInt(data.value.carbohydrates))
    formData.append('price', parseInt(data.value.price))
    formData.append('amount', parseInt(data.value.amount))

    try {
        await Product.update(formData)
        isFormRequestStatus.value = true
        message.value = 'Product updated.'
    } catch (err) {
        isFormRequestStatus.value = false
        message.value = err.response.data.message
    }
}
</script>

<template>
    <Card>
        <div>
            <Input placeholder="Name" type="text" v-model="data.name" :value="product.name"/>
            <Textarea placeholder="Description" @input="updateDescription" :value="product.description"></Textarea>

            <div uk-form-custom="target: true">
                <input type="file" aria-label="Custom controls" ref="image">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select image"
                       aria-label="Custom controls" disabled>
            </div>

            <div class="uk-flex-inline uk-margin-small-top uk-margin-small-bottom">
                <Input placeholder="Proteins" type="number" v-model="data.proteins" :value="product.nutritional?.proteins"/>
                <Input placeholder="Fats" type="number" v-model="data.fats" :value="product.nutritional?.fats"/>
                <Input placeholder="Carbohydrates" type="number" v-model="data.carbohydrates" :value="product.nutritional?.carbohydrates"/>
            </div>

            <Textarea placeholder="Composition" @input="updateComposition" :value="product.composition"></Textarea>
            <Input placeholder="Price" type="number" v-model="data.price" :value="product.price"/>
            <Input placeholder="Amount" type="number" v-model="data.amount" :value="product.amount"/>

            <Button type="primary" @click="submit()">Update</Button>
        </div>

        <Success v-if="isFormRequestStatus === true">Success. {{ message }}</Success>
        <Error v-if="isFormRequestStatus === false">Error. {{ message }}</Error>
    </Card>
</template>
