<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
    value: string,
    options: Array<string>
}>()

const value = ref<string>(props.value)
</script>

<template>
    <select class="uk-select" v-model="value">
        <option v-for="val in options" :value="val" :key="val">{{ val.charAt(0).toUpperCase() + val.slice(1) }}</option>
    </select>
</template>