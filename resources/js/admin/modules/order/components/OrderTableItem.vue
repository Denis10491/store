<script setup lang="ts">
import {getPriceOfProducts, toDateViewFormat} from "@helpers/functions";
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import { Status } from "@admin/modules/order/enums/Status";
import { ref, watch } from "vue";
import { Order } from "@admin/modules/order/services/order";

const props = defineProps<IOrder>()

const status = ref<Status>(props.status)

const updateStatusOrder = async (newStatus: Status) => {
    await Order.updateStatus(Number(props.id), newStatus)
}

watch(status, (newStatus: Status) => {
    updateStatusOrder(newStatus)
})
</script>

<template>
    <tr>
        <td>{{ id }}</td>
        <td>{{ address }}</td>
        <td>
            <p v-for="product in products" :key="product.id">
                {{ product.name + ' x' + product.count + ' (' + product.price + ')' }}</p>
        </td>
        <td>{{ getPriceOfProducts(products!) }}</td>
        <td>{{ toDateViewFormat(created_at!) }}</td>
        <td>
            <div class="uk-margin">
                <div class="uk-form-controls">
                    <select class="uk-select" v-model="status">
                        <option v-for="val in Status" :value="val" :key="val">{{ val.charAt(0).toUpperCase() + val.slice(1) }}</option>
                    </select>
                </div>
            </div>
        </td>
    </tr>
</template>
