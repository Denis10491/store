<script setup lang="ts">
import ProductCard from "@user/modules/product/views/ProductCard.vue";

const props = defineProps<{ id: string }>()
</script>

<template>
    <ProductCard :id="parseInt(props.id)"/>
</template>
