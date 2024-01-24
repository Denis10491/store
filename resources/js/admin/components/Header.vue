<template>
    <header class="uk-card uk-card-default uk-flex uk-flex-between uk-flex-middle uk-background-default uk-width-1-1 uk-padding-small border">
        <a href="/">Store</a>
        <ul class="uk-nav uk-nav-default uk-width-1-1 uk-flex">
            <li>
                <router-link to="/admin"><span uk-icon="icon: home; ratio: 1"></span> Home</router-link>
            </li>
            <li :class="{'uk-active': path == '/admin/products'}">
                <router-link to="/admin/products"><span uk-icon="icon: bag; ratio: 1"></span> Products</router-link>
            </li>
            <li :class="{'uk-active': path == '/admin/orders'}">
                <router-link to="/admin/orders"><span uk-icon="icon: table; ratio: 1"></span> Orders</router-link>
            </li>
            <li :class="{'uk-active': path == '/admin/statistics'}">
                <router-link to="/admin/statistics"><span uk-icon="icon: info; ratio: 1"></span> Statistics</router-link>
            </li>
        </ul>

        <div class="uk-flex uk-flex-center uk-flex-middle">
            <span class="uk-margin-small-right uk-text-uppercase uk-text-small">administrator</span>
        <a href="#" class="uk-icon-button" uk-icon="sign-out" @click="logout()"></a>
        </div>
    </header>
</template>

<script>
import axios from 'axios';

export default {
    name: 'HeaderComponent',

    methods: {
        logout() {
            axios.get('/logout', {
                headers: {
                    Authorization: 'Bearer ' + sessionStorage.getItem('token')
                }
            })
            .then(() => {
                sessionStorage.removeItem('token');
                window.location.href = '/';
            })
        }
    }
}
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