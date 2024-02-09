<template>
    <input :type="props.type" class="uk-input uk-margin-small-bottom" :placeholder="props.placeholder" v-model="value">
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from "vue";

const props = defineProps<{
    placeholder: string,
    type: string,
    value: string
}>();
const value = ref<string>(props.value);

onMounted(() => {
    watch(() => props.value, newValue => {
        value.value = newValue;
    });
});

const emit = defineEmits<{
  (e: 'update:value', value: string): void
}>()
watch(() => value.value, newValue => {
    emit('update:value', newValue);
});
</script>