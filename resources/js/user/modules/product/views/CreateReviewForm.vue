<script setup lang="ts">
import {reactive, ref} from "vue";
import type {ICreateReview} from "@user/modules/product/interfaces/ICreateReview";
import {Review} from "@user/modules/product/services/review";
import {Product} from "@user/modules/product/services/product";
import Error from "@components/Error.vue";
import Button from "@ui/Button.vue";
import Input from "@ui/Input.vue";
import Textarea from "@ui/Textarea.vue";

const props = defineProps<{ productId: number }>()

let data = reactive<ICreateReview>({
    body: '',
    rating: 5
})
let isFormRequestStatus = ref<boolean>(true)
let errorMessage = ref<string>('')

const validate = () => {
    if (!data.body) {
        errorMessage.value = 'Error. Body is empty.'
        isFormRequestStatus.value = false
    }

    if (!data.rating) {
        errorMessage.value = 'Error. Rating is empty.'
        isFormRequestStatus.value = false
    }

    return isFormRequestStatus.value
}

const submit = async () => {
    isFormRequestStatus.value = true

    if (validate()) {
        const review = await Review.create(props.productId, data)

        if (!review) {
            errorMessage.value = 'Error. You need to log in.'
            isFormRequestStatus.value = false
        }

        Product.store.list.unshift(review)
    }
}
</script>

<template>
    <div class="uk-margin-bottom uk-width-medium">
        <Input placeholder="Rating" type="number" min="1" max="5" v-model="data.rating" :value="data.rating"/>
        <Textarea placeholder="Text" v-model="data.body" :value="data.body"/>
        <Button type="primary" @click="submit()">Rate</Button>
        <Error v-if="!isFormRequestStatus">{{ errorMessage }}</Error>
    </div>
</template>
