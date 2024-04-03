<script setup lang="ts">
import Button from "@ui/Button.vue";

const props = defineProps<{ title: string }>()
</script>

<template>
    <div id="open-form-product" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical border" style="overflow: hidden;">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header uk-flex uk-flex-center uk-flex-middle">
                <p class="uk-modal-title">{{ props.title }}</p>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.uk-modal-close-default {
    left: inherit;
    top: 20px;
    right: 20px;
}
</style>
