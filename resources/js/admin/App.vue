<template>
    <main class="main container uk-width-1-1">
        <Header></Header>
        <div class="content uk-card uk-card-default uk-padding">
            <router-view></router-view>
        </div>
    </main>
</template>

<script setup lang="ts">
import Header from '@admin/components/layout/Header.vue';
</script>

<style>
.main .content {
    width: auto !important;
    border-radius: 50px;
    max-height: calc(100vh - 146px);
    overflow: scroll;
}
</style>