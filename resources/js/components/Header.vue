<template>
    <header class="header uk-background-secondary">
        <div class="header__content container">
            <a href="/" class="header__logo">
                <img src="../../assets/images/logo.png" alt="logo" class="header__logo-img">
            </a>
            <nav class="header__nav" v-if="isAdmin">
                <router-link to="/admin" class="header__nav-item">Administration panel</router-link>
                <router-link to="/basket" class="header__nav-item">Basket</router-link>
                <router-link to="/profile" class="header__nav-item">Profile</router-link>
                <router-link to="/logout" class="header__nav-item uk-button uk-button-primary">Logout</router-link>
            </nav>
            <nav class="header__nav" v-else-if="!isAdmin && isAuth">
                <router-link to="/basket" class="header__nav-item">Basket</router-link>
                <router-link to="/profile" class="header__nav-item">Profile</router-link>
                <router-link to="/logout" class="header__nav-item uk-button uk-button-primary">Logout</router-link>
            </nav>
            <nav class="header__nav" v-else>
                <router-link to="/basket" class="header__nav-item">Basket</router-link>
                <router-link to="/login" class="header__nav-item">Log In</router-link>
                <router-link to="/signup" class="header__nav-item uk-button uk-button-primary">Sign Up</router-link>
            </nav>
        </div>
    </header>
</template>

<script>
import { useUserStore } from '../store/user'

export default {
    name: 'HeaderComponent',

    setup() {
        const userStore = useUserStore();
        return { userStore }
    },

    computed: {
        isAdmin() {
            return this.userStore.isAdmin;
        },
        isAuth() {
            return this.userStore.isAuth;
        }
    }
}
</script>

<style>
.header a {
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-size: 13px;
    margin: 0 0 0 15px;
}
</style>