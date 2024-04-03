<script setup lang="ts">
import OrderTable from "@user/modules/order/views/OrderTable.vue";
import Card from "@ui/Card.vue";
</script>

<template>
    <h1 class="title">Profile</h1>
    <Card>
        <h3>Orders</h3>
        <OrderTable/>
    </Card>
</template>
