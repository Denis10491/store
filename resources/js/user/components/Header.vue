<script setup lang="ts">
import {computed} from 'vue';
import {GITHUB_REPOSITORY} from '@helpers/constants';
import Button from '@ui/Button.vue';
import {Auth} from "@user/modules/auth/services/auth";
import {useUserStore} from "@user/modules/user/store/user";

const exit = async (): Promise<void> => {
    await Auth.logout();
    window.location.href = '/';
}

const userStore = useUserStore();
const isAuth = computed<boolean>(() => userStore.getIsAuth);
</script>

<template>
    <header
        class="uk-card uk-card-default uk-flex uk-flex-between uk-flex-middle uk-flex-center uk-background-default uk-width-1-1 uk-padding-small border">
        <ul v-if="isAuth" class="uk-nav uk-nav-default uk-width-1-1 uk-flex uk-flex-middle">
            <a href="/" class="header__logo">Store</a>
            <li>
                <router-link to="/basket" class="header__nav-item">Basket</router-link>
            </li>
            <li>
                <router-link to="/about" class="header__nav-item">About</router-link>
            </li>
            <li>
                <router-link to="/profile" class="header__nav-item">Profile</router-link>
            </li>
        </ul>
        <ul v-else class="uk-nav uk-nav-default uk-width-1-1 uk-flex uk-flex-middle">
            <a href="/" class="header__logo">Store</a>
            <li>
                <router-link to="/about" class="header__nav-item">About</router-link>
            </li>
            <li>
                <router-link to="/basket" class="header__nav-item">Basket</router-link>
            </li>
        </ul>

        <a :href="GITHUB_REPOSITORY" target="_blanc" class="uk-icon-button" uk-icon="github"></a>
        <a v-if="isAuth" href="#" class="uk-icon-button" uk-icon="sign-out" @click="exit()"></a>
        <nav v-else class="uk-flex uk-flex-middle">
            <router-link to="/login" class="header__nav-item">Login</router-link>
            <router-link to="/signup" class="header__nav-item">
                <Button type="primary">Singup</Button>
            </router-link>
        </nav>
    </header>
</template>

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

.header__nav-item {
    cursor: pointer;
}

header button {
    margin: 0 !important;
}
</style>
