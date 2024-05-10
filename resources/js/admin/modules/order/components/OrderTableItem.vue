<script setup lang="ts">
import {getPriceOfProducts, toDateViewFormat} from "@helpers/functions";
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import { Status } from "@admin/modules/order/enums/Status";
import { ref, watch } from "vue";
import { Order } from "@admin/modules/order/services/order";
import Select from "@ui/Select.vue";

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
                    <Select 
                        v-model="status" 
                        :value="status" 
                        :options="Object.values(Status)"
                    ></Select>
                </div>
            </div>
        </td>
    </tr>
</template>
