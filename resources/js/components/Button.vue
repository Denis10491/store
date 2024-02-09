<template>
    <button :class="'uk-button uk-margin-small-bottom uk-button-'+type">
        <slot></slot>
    </button>
</template>

<script setup lang="ts">
import { ref } from "vue"

const props = defineProps<{
    type: string
}>()
const type = ref<string>(props.type ? props.type : 'primary')
</script>