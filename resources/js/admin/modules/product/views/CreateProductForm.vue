<script setup lang="ts">
import {ref} from "vue";
import type {ICreateProduct} from "@admin/modules/product/interfaces/ICreateProduct";
import Card from "@ui/Card.vue";
import Input from "@ui/Input.vue";
import Button from "@ui/Button.vue";
import Error from "@components/Error.vue";
import Textarea from "@ui/Textarea.vue";
import {Product} from "@admin/modules/product/services/product";
import Success from "@components/Success.vue";

const data = ref<ICreateProduct>({
    name: '',
    description: '',
    composition: '',
    fats: NaN,
    proteins: NaN,
    carbohydrates: NaN,
    price: NaN,
})
let image = ref<HTMLInputElement>()
let isFormRequestStatus = ref<boolean | null>(null)
let message = ref<string>('')

const submit = async () => {
    const formData: FormData = new FormData()

    if (image.value?.files) {
        formData.append('image', image.value.files[0])
    }

    formData.append('name', data.value.name)
    formData.append('description', data.value.description)
    formData.append('composition', data.value.composition)
    formData.append('fats', data.value.fats.toPrecision())
    formData.append('proteins', data.value.proteins.toPrecision())
    formData.append('carbohydrates', data.value.carbohydrates.toPrecision())
    formData.append('price', data.value.price.toPrecision())

    try {
        const product = await Product.create(formData)

        Product.store.list.push(product)

        isFormRequestStatus.value = true
        message.value = 'Product created.'
    } catch (err) {
        isFormRequestStatus.value = false
        message.value = err.response.data.message
    }
}
</script>

<template>
    <Card>
        <div>
            <Input placeholder="Name" type="text" v-model="data.name" :value="data.name"/>
            <Textarea placeholder="Description" v-model="data.description" :value="data.description"></Textarea>

            <div uk-form-custom="target: true">
                <input type="file" aria-label="Custom controls" ref="image">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select image"
                       aria-label="Custom controls" disabled>
            </div>

            <div class="uk-flex-inline uk-margin-small-top uk-margin-small-bottom">
                <Input placeholder="Proteins" type="number" v-model="data.proteins"
                       :value="data.proteins"/>
                <Input placeholder="Fats" type="number" v-model="data.fats" :value="data.fats"/>
                <Input placeholder="Carbohydrates" type="number" v-model="data.carbohydrates"
                       :value="data.carbohydrates"/>
            </div>

            <Textarea placeholder="Composition" v-model="data.composition" :value="data.composition"></Textarea>
            <Input placeholder="Price" type="number" v-model="data.price" :value="data.price"/>

            <Button type="primary" @click="submit()">Create</Button>
        </div>

        <Success v-if="isFormRequestStatus === true">Success. {{ message }}</Success>
        <Error v-if="isFormRequestStatus === false">Error. {{ message }}</Error>
    </Card>
</template>
