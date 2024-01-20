<template>
<h1 class="title">Profile</h1>
<div class="uk-card uk-card-default uk-padding uk-width-auto">
    <h3>Orders</h3>
    <div class="uk-margin-top">
        <Orders :data="orders" />
    </div>
</div>
</template>

<script>
import Orders from '../components/Orders.vue';
import { useOrdersStore } from '../store/orders';

export default {
    name: 'ProfilePage',
    components: { Orders },

    setup() {
        const ordersStore = useOrdersStore();
        return { ordersStore }
    },

    created() {
        this.ordersStore.showByUserId();
    },

    computed: {
        orders() {
            return this.ordersStore.filteredList ?? [];
        }
    }
}
</script>

<style scoped>
.profile__title h1, h3 {
    margin: 0;
}
</style>