<script setup lang="ts">
import {ref} from "vue";

const props = defineProps<{
    placeholder: '',
    value: ''
}>()

const value = ref<string>(props.value)
</script>

<template>
    <textarea class="uk-textarea uk-padding-small border uk-margin-small-bottom" :placeholder="placeholder"
              v-model="value"
              rows="3"></textarea>
</template>
