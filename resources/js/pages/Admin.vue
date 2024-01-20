<template>
    <div class="uk-card uk-card-default uk-padding uk-width-auto">
        <h1 class="title">Administration panel</h1>
        <nav>
            <button class="uk-button uk-button-default uk-button-dark"
                :class="{'uk-button-primary': menu.orders}"
                @click="activeMenuItem('orders')"
            >Orders</button>
            <button class="uk-button uk-button-default uk-margin-small-left"
                :class="{'uk-button-primary': menu.statistics}"
                @click="activeMenuItem('statistics')"
            >Statistics</button>
            <button class="uk-button uk-button-default uk-margin-small-left"
                :class="{'uk-button-primary': menu.products}"
                @click="activeMenuItem('products')"
            >Products</button>
        </nav>

        <div class="uk-margin-top">
            <Orders :data="ordersStore.filteredList" v-if="menu.orders" />
            <Statistics v-if="menu.statistics" />
            <Products v-if="menu.products" />
        </div>
    </div>
</template>

<script>
import Orders from '../components/Orders.vue'
import Statistics from '../components/Admin/statistics.vue';
import Products from '../components/Admin/Products.vue';
import { useOrdersStore } from '../store/orders';

export default {
    name: 'AdminPage',

    components: {
        Orders, Statistics, Products
    },

    data() {
        return {
            menu: {
                orders: true,
                statistics: false,
                products: false
            }
        }
    },

    setup() {
        const ordersStore = useOrdersStore()
        return { ordersStore }
    },

    mounted() {
        this.ordersStore.getAll()
    },

    methods: {
        activeMenuItem(name) {
            Object.keys(this.menu).map(key => {
                this.menu[key] = false;
            })
            this.menu[name] = true;
        }
    }
}
</script>