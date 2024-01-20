<template>
    <nav class="filter uk-flex uk-flex-bottom uk-margin-small-top uk-margin-small-bottom">
        <div>
            <label class="uk-form-label" for="form-stacked-text">Date Start</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="filter.dateStart">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label" for="form-stacked-text">Date End</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="filter.dateEnd">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label" for="form-stacked-text">Product Name</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" v-model="filter.productName" placeholder="Type here...">
            </div>
        </div>
        <button class="uk-button uk-button-primary uk-height-1-1 uk-margin-small-left"
            @click="ordersStore.filter(filter.dateStart, filter.dateEnd, filter.productName)"
        >Accept</button>
        <button class="uk-button uk-button-default uk-height-1-1 uk-margin-small-left"
            @click="clearFilter()"
        >Clear</button>
    </nav>

    <div class="order-card uk-card uk-margin-small-top uk-margin-small-bottom" v-if="data">
        <div v-for="order in data" :key="order.id">
            <hr>
            <div class="order-title">
                <h3>{{ 'Date: ' + order.created_at.slice(0, 10) }}</h3>
                <h3>{{ 'Address: ' + order.address }}</h3>
            </div>
            <div class="order-products">
                <p v-for="product in order.products" :key="product.id">{{ product.name + ' x'+product.count+' ('+product.price+')' }}</p>
            </div>
            <h3>{{ 'Price: ' + priceOfOrder(order.products) }}</h3>
        </div>
    </div>

    <div v-if="data.length == 0" class="uk-padding-small">
        <p>Loading...</p>
    </div>
</template>

<script>
import { useOrdersStore } from '../store/orders';

export default {
    name: 'AdminOrdersComponent',
    props: [ 'data' ],

    data() {
        return {
            filter: {
                dateStart: null,
                dateEnd: null,
                productName: ""
            }
        }
    },

    setup() {
        const ordersStore = useOrdersStore();
        return { ordersStore }
    },

    methods: {
        priceOfOrder(products) {
            let price = 0;
            products.map(product => {
                price += product.price
            })
            return price;
        },

        clearFilter() {
            this.filter = {
                dateStart: null,
                dateEnd: null,
                productName: ""
            }
            this.ordersStore.filter();
        }
    }
}
</script>

<style>
.filter input {
    width: 160px;
    display: flex;
    align-items: center;
}
.order-card h3, div, p {
    margin: 0;
    letter-spacing: 1.2px;
}
.order-title > * {
    margin: 0 10px 0 0;
}
</style>