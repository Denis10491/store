<template>
    <nav class="filter uk-flex uk-flex-bottom uk-margin-small-top uk-margin-small-bottom">
        <div>
            <label class="uk-form-label">Date Start</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="dateStart">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label">Date End</label>
            <div class="uk-form-controls">
                <input type="date" class="uk-input" v-model="dateEnd">
            </div>
        </div>
        <div class="uk-margin-small-left">
            <label class="uk-form-label">Product Name</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" v-model="productName" placeholder="Type here...">
            </div>
        </div>
        <Button type="primary" class="uk-margin-small-left"
                @click="ordersStore.filter(dateStart, dateEnd, productName)"
        >Accept
        </Button>
        <Button type="default" class="uk-margin-small-left"
                @click="clearFilter()"
        >Clear
        </Button>
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
        <tr v-for="order in orders[currentPage]" :key="order.id">
            <td>{{ order.id }}</td>
            <td>{{ order.address }}</td>
            <td>
                <p v-for="product in order.products" :key="product.product_id">
                    {{ product.name + ' x' + product.count + ' (' + product.price + ')' }}</p>
            </td>
            <td>{{ getPriceOfProducts(order.products) }}</td>
            <td>{{ order.created_at.toString().slice(0, 10).split('-').join('.') }}</td>
        </tr>
        </tbody>
    </table>

    <Paginator
        v-if="loaded"
        :currentPage="currentPage"
        :changePage="changePage"
        :numOfMaxPage="ordersStore.getLastPage"
    />

    <h2 v-if="!loaded">Loading...</h2>
</template>

<script setup lang="ts">
import {computed, onMounted, ref} from 'vue';
import {useOrdersStore} from '@user/store/orders';
import {getPriceOfProducts} from '@helpers/functions';
import {ArrayOrder} from '@helpers/interfaces';
import Button from '@ui/Button.vue';
import Paginator from '@components/Paginator.vue';

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

const clearFilter = () => {
    dateStart.value = '';
    dateEnd.value = '';
    productName.value = '';
    ordersStore.filter();
}

const orders = computed((): ArrayOrder => ordersStore.filteredList);

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

.filter button {
    margin-bottom: 0 !important;
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
