<template>
    <div>
        <div class="uk-flex uk-flex-center uk-flex-middle">
            <Button type="default" class="uk-margin-small-right"
                    @click="emit('plus', id)"
            >+
            </Button>
            <p>{{ props.count }}</p>
            <Button type="default" class="uk-margin-small-left"
                    @click="emit('minus', id)"
            >-
            </Button>
        </div>
        <Button type="danger"
                @click="emit('remove', id)"
        >Remove
        </Button>
    </div>
</template>

<script setup lang="ts">
import Button from '@ui/Button.vue';

const emit = defineEmits<{
    (e: 'plus', id: number): Promise<void>,
    (e: 'minus', id: number): Promise<void>,
    (e: 'remove', id: number): Promise<void>,
}>()

const props = defineProps<{
    id: number,
    count: number
}>()
</script>
