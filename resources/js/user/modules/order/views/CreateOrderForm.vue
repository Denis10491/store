<script setup lang="ts">
import {computed, reactive, ref} from "vue";
import {getPriceOfProducts} from "@helpers/functions";
import {useUserStore} from "@user/modules/user/store/user";
import {useBasketStore} from "@user/modules/product/store/basket";
import type {IOrder} from "@user/modules/order/interfaces/IOrder";
import {Order} from "@user/modules/order/services/order";
import Error from "@components/Error.vue";
import Button from "@ui/Button.vue";
import Input from "@ui/Input.vue";
import Card from "@ui/Card.vue";

const userStore = useUserStore()
const basketStore = useBasketStore()

const sum = computed<number>(() => getPriceOfProducts(basketStore.getList))
let isFormRequestStatus = ref<boolean>(true)
let formData = reactive<IOrder>({
    address: ''
})

const submit = async () => {
    isFormRequestStatus.value = true
    formData.products = basketStore.getList

    if (!userStore.getIsAuth) {
        window.location.href = '/login'
    }

    if (await Order.create(formData)) {
        window.location.href = '/profile'
    }

    isFormRequestStatus.value = false
}
</script>

<template>
    <Card class="uk-flex-column uk-margin-small-left uk-width-1-2 uk-height-1-1">
        <h3>Оформление заказа</h3>
        <Input type="text" class="uk-input uk-margin-small-bottom" placeholder="Address" v-model="formData.address"
               :value="formData.address"/>
        <div class="uk-flex uk-flex-end uk-flex-middle">
            <Button type="primary" @click="submit()">Buy</Button>
            <p class="uk-margin-small-left">Sum: {{ sum }}</p>
        </div>
        <Error v-if="!isFormRequestStatus">We were unable to place your order. Try later</Error>
    </Card>
</template>

<style scoped>
button {
    margin: 0 !important;
}
</style>
