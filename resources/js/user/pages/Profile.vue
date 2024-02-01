<template>
<h1 class="title">Profile</h1>
<div class="uk-card uk-card-default uk-padding uk-width-auto border">
    <h3>Orders</h3>
    <div class="uk-margin-top">
        <Orders />
    </div>
</div>
</template>

<script>
import Orders from '../components/orders/Orders.vue';

export default {
    name: 'ProfilePage',
    components: { Orders }
}
</script>

<style scoped>
.profile__title h1, h3 {
    margin: 0;
}
</style>