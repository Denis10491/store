<script setup lang="ts">
import {computed} from "vue";

const props = defineProps<{
    placeholder: string,
    value: string
}>()

const value = computed(() => props.value)
</script>

<template>
    <textarea 
        class="uk-textarea uk-padding-small border uk-margin-small-bottom" 
        :placeholder="placeholder" 
        rows="3"
        @input="$emit('input', $event.target.value)"
    >{{ value }}</textarea>
</template>
