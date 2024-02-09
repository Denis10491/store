<template>
    <h1 class="title">Profile</h1>
    <Card>
        <h3>Orders</h3>
        <Orders />
    </Card>
</template>

<script setup lang="ts">
import Card from '../../components/Card.vue';
import Orders from '../components/orders/Orders.vue';
</script>