<script setup lang="ts">
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Colors,
    Legend,
    LinearScale,
    Title,
    Tooltip
} from 'chart.js'
import {computed, ref} from "vue";
import OrdersChart from "@admin/modules/order/views/OrdersChart.vue";
import ProductsBestSellingChart from "@admin/modules/product/views/ProductsBestSellingChart.vue";
import Card from "@ui/Card.vue";
import Input from "@ui/Input.vue";
import {Order} from "@admin/modules/order/services/order";
import {Product} from "@admin/modules/product/services/product";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, Colors)

const baseMaxProducts = 5
const chartOptions = {responsive: true}

let maxProducts = ref<number>(5)

let date = ref<Date>(new Date())
let month = ref<number | null>(null)
let year = ref<number | null>(null)
const updateDate = () => {
    year.value = new Date(date.value).getFullYear();
    month.value = new Date(date.value).getMonth() + 1;
}
const clear = () => {
    date.value = new Date()
    maxProducts.value = baseMaxProducts
}


let orders = ref<Array<any>>([])
let products = ref<Array<any>>([])
const updateData = async () => {
    updateDate()
    orders.value = await Order.statistics(year.value!, month.value!)
    products.value = await Product.statistics(year.value!, month.value!)
}
updateData()

const ordersChart = computed(() => {
    let data = {};
    Object.keys(orders.value).map(key => data[key] = orders.value[key]);
    return {
        labels: Object.keys(orders.value).sort(),
        datasets: [{
            label: new Date(date.value),
            data: data
        }]
    }
})
const productsChart = computed(() => {
    let labels: Array<string> = [];
    let data: Array<number> = [];

    Object.keys(products.value).slice(0, maxProducts.value).map(key => {
        labels.push(products.value[key].name);
        data.push(products.value[key].total_count);
    });

    return {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: [
                '#3D3B8E', '#BBBE64', '#6883BA', 'rgb(255, 99, 132)',
                '#AFCBFF', '#0E1C36', '#D7F9FF', 'rgb(54, 162, 235)',
                '#A10702', '#FAA613', '#883677', 'rgb(255, 205, 86)',
            ],
            hoverOffset: 4
        }]
    }
})
</script>

<template>
    <div uk-grid>
        <div>
            <div class="filter uk-flex uk-flex-bottom uk-margin-small-top uk-margin-small-bottom">
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Date</label>
                    <div class="uk-form-controls">
                        <Input type="date" class="uk-input" v-model="date" :value="date" placeholder=""/>
                    </div>
                </div>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Max products</label>
                    <div class="uk-form-controls">
                        <Input type="text" class="uk-input" placeholder="Max products" v-model="maxProducts"
                               :value="maxProducts"/>
                    </div>
                </div>
                <button class="uk-button uk-button-primary uk-height-1-1 uk-margin-small-left" @click="updateData()">
                    Accept
                </button>
                <button class="uk-button uk-button-default uk-height-1-1 uk-margin-small-left" @click="clear()">Clear
                </button>
            </div>
        </div>
    </div>

    <div v-if="products.length > 0 && Object.keys(orders).length > 0" uk-grid class="uk-height-1-2">
        <OrdersChart
            :data="ordersChart"
            :options="chartOptions"
        />
        <ProductsBestSellingChart
            :data="productsChart"
            :options="chartOptions"
        />
    </div>
    <Card v-else class="uk-padding-small">Loading...</Card>
</template>
