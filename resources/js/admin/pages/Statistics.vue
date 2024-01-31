<template>
    <div uk-grid>
        <div>
            <div class="filter uk-flex uk-flex-bottom uk-margin-small-top uk-margin-small-bottom">
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Date</label>
                    <div class="uk-form-controls">
                        <input type="date" class="uk-input" v-model="date">
                    </div>
                </div>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Max products</label>
                    <div class="uk-form-controls">
                <input type="text" class="uk-input" placeholder="Max products" v-model="maxProducts">
                    </div>
                </div>
                <button class="uk-button uk-button-primary uk-height-1-1 uk-margin-small-left"
                    @click="updateAllData()"
                >Accept</button>
                <button class="uk-button uk-button-default uk-height-1-1 uk-margin-small-left"
                    @click="clearOrders()"
                >Clear</button>
            </div>
        </div>
        <div v-if="statisticsStore.$state.ordersInSelectedMonth.length == 0" class="uk-padding-small">
            <p>Loading...</p>
        </div>
    </div>
    <div uk-grid class="uk-height-1-2">
        <div class="uk-width-1-2">
            <p>Orders per month</p>
            <Bar 
                v-if="loaded"
                id="ordersByMonth"
                :options="chartOptions"
                :data="dataForOrdersChart"
            />
        </div>
        <div class="uk-width-1-2">
            <p>Best selling products per month</p>
            <Pie 
                v-if="loaded"
                :options="chartOptions"
                :data="dataForBestSellingChart"
            />
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, Colors } from 'chart.js'
import { useStatisticsStore } from '../store/statistics'

export default {
    name: 'AdminStatisticsComponent',
    components: { Bar, Pie },

    data() {
        return {
            date: new Date(),
            year: null,
            month: null,
            loaded: false,
            chartOptions: {
                responsive: true
            },
            maxProducts: 5,
            baseMaxProducts: 5
        }
    },

    setup() {
        ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, Colors)
        const statisticsStore = useStatisticsStore();
        return { statisticsStore }
    },

    mounted() {
        this.updateAllData();
    },

    methods: {
        updateDate() {
            let dateForReq = new Date(this.date);
            this.year = dateForReq.getFullYear(),
            this.month = dateForReq.getMonth() + 1;
        },

        updateAllData() {
            this.updateDate();
            this.statisticsStore.getCountOfOrders(this.year, this.month);
            this.statisticsStore.getBestSellingProducts(this.year, this.month);
            this.loaded = true;
        },

        clearOrders() {
            this.date = new Date();
            this.maxProducts = this.baseMaxProducts;
            this.updateOrders()
        }
    },

    computed: {
        orders() {
            return this.statisticsStore.ordersInSelectedMonth ?? [];
        },

        products() {
            return this.statisticsStore.bestSelling ?? [];
        },

        dataForBestSellingChart() {
            let labels = [];
            let data = [];

            Object.keys(this.products).slice(0, this.maxProducts).map(key => {
                labels.push(this.products[key].name);
                data.push(this.products[key].count);
            });

            return {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#3D3B8E', '#BBBE64', '#6883BA',
                        'rgb(255, 99, 132)',
                        '#AFCBFF', '#0E1C36', '#D7F9FF', 
                        'rgb(54, 162, 235)',
                        '#A10702', '#FAA613', '#883677',
                        'rgb(255, 205, 86)', 
                    ],
                    hoverOffset: 4
                }]
            }
        },

        dataForOrdersChart() {
            let data = {};
            Object.keys(this.orders).map(key => data[key] = this.orders[key].length);
            return {
                labels: Object.keys(this.orders).sort(),
                datasets: [{
                    label: new Date(this.date),
                    data: data
                }]
            }
        }
    }
}
</script>