<template>
    <nav class="filter uk-flex uk-flex-bottom uk-margin-small-top uk-margin-small-bottom">
        <div>
            <label class="uk-form-label" for="form-stacked-text">Date Start</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="dateStart">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label" for="form-stacked-text">Date End</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="dateEnd">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label" for="form-stacked-text">Product Name</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" v-model="productName" placeholder="Type here...">
            </div>
        </div>
        <button class="uk-button uk-button-primary uk-height-1-1 uk-margin-small-left"
            @click="ordersStore.filter(dateStart, dateEnd, productName)"
        >Accept</button>
        <button class="uk-button uk-button-default uk-height-1-1 uk-margin-small-left"
            @click="clearFilter()"
        >Clear</button>
    </nav>

    <table v-if="loaded" class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Address</th>
                <th>Products</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders[currentPage]" :key="order['id']">
                <td>{{ order['id'] }}</td>
                <td>{{ order['address'] }}</td>
                <td>
                    <p v-for="product in order['products']" :key="product['id']">{{ product.name + ' x'+product.count+' ('+product.price+')' }}</p>
                </td>
                <td>{{ priceOfOrder(order['products']) }}</td>
                <td>{{ order['created_at'].slice(0, 10).replaceAll('-', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <Paginator
        v-if="loaded"
        :currentPage="currentPage"
        :changePage="changePage"
        :numOfMaxPage="ordersStore.getLastPage"
    />

    <div v-if="!loaded" class="uk-padding-small">
        <p>Loading...</p>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import { useOrdersStore } from '@user/store/orders';
import { Order, Product } from '@helpers/interfaces';

const loaded = ref<boolean>(false);
const currentPage = ref<number>(1);
let dateStart = ref('');
let dateEnd = ref('');
let productName = ref('');

const ordersStore = useOrdersStore();

const changePage = async (num: number) => {
    loaded.value = false;
    await ordersStore.getPage(num);
    setTimeout(() => {
        (ordersStore.lastPage < num)
        ? currentPage.value = ordersStore.lastPage
        : currentPage.value = num;
        loaded.value = true;
    }, 500);
}

const priceOfOrder = (products: Product[]): number => {
    let price = 0;
    products.map(product => {
        price += product.price
    })
    return price;
}

const clearFilter = () => {
    dateStart.value = '';
    dateEnd.value = '';
    productName.value = '';
    ordersStore.filter();
}

const orders = computed((): Array<Order> => ordersStore.filteredList);

onMounted(async () => {
    loaded.value = await ordersStore.getPage(1);
})
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
.uk-table th {
    text-align: start;
}
</style>