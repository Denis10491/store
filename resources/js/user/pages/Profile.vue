<template>
    <h1 class="title">Profile</h1>
    <Card>
        <h3>Orders</h3>
        <Orders/>
    </Card>
</template>

<script setup lang="ts">
import Card from '@ui/Card.vue';
import Orders from '@user/components/orders/Orders.vue';
</script>
