<script setup lang="ts"></script>

<template>
    <div
        class="uk-alert-danger uk-width-1-1 uk-padding-small border uk-flex uk-flex-center uk-flex-middle uk-margin-small-top">
        <p>
            <slot></slot>
        </p>
    </div>
</template>

<style scoped>
p {
    margin: 0;
}
</style>
