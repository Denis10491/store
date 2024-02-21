<template>
    <header class="uk-card uk-card-default uk-flex uk-flex-between uk-flex-middle uk-background-default uk-width-1-1 uk-padding-small border">
        <a href="/">Store</a>
        <ul class="uk-nav uk-nav-default uk-width-1-1 uk-flex">
            <li>
                <router-link to="/admin"><span uk-icon="icon: home; ratio: 1"></span> Home</router-link>
            </li>
            <li>
                <router-link to="/admin/products"><span uk-icon="icon: bag; ratio: 1"></span> Products</router-link>
            </li>
            <li>
                <router-link to="/admin/orders"><span uk-icon="icon: table; ratio: 1"></span> Orders</router-link>
            </li>
            <li>
                <router-link to="/admin/statistics"><span uk-icon="icon: info; ratio: 1"></span> Statistics</router-link>
            </li>
        </ul>

        <div class="uk-flex uk-flex-center uk-flex-middle">
            <span class="uk-margin-small-right uk-text-uppercase uk-text-small">administrator</span>
            <a href="https://github.com/Divrun/Store-Laravel-Vue" target="_blanc" class="uk-icon-button" uk-icon="github"></a>
            <a href="#" class="uk-icon-button" uk-icon="sign-out" @click="logout()"></a>
        </div>
    </header>
</template>

<script setup lang="ts">
import { logout } from '@admin/services/api';
</script>

<style scoped>
header {
    margin: 0 0 20px;
}
header a {
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-size: 13px;
    margin: 0 0 0 15px;
}
</style>