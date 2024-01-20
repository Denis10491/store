<template>
    <h3>{{ redirectStatus }}</h3>
</template>

<script>
import { useUserStore } from '../store/user';

export default {

    data() {
        return {
            redirectStatus: "Redirection in progress"
        }
    },

    setup() {
        const userStore = useUserStore();
        return { userStore }
    },

    async created() {
        const isLogoutStatus = await this.userStore.logout();
        if (isLogoutStatus) window.location.href = '/'
        else this.redirectStatus = "Couldn't log out of your account"
    }
}</script>