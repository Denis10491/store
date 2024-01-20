<template>
    <form class="uk-card uk-card-default uk-padding" @submit.prevent="send()">
        <h3>Login to your account</h3>
        <input type="email" class="uk-input" placeholder="Email" v-model="email">
        <input type="password" class="uk-input" placeholder="Password" v-model="password">
        <button class="uk-button uk-background-primary uk-light">LogIn</button>
        <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
            <p>Error. Incorrect data entered</p>
        </div>
    </form>
</template>

<script>
import { useAuthStore } from '../store/auth'

export default {
    name: 'LoginPage',

    data() {
        return {
            email: "",
            password: "",
            isFormRequestStatus: true
        }
    },

    setup() {
        const authStore = useAuthStore()
        return { authStore }
    },

    methods: {
        async send() {
            this.isFormRequestStatus = true;
            const isAuthStatus = await this.authStore.login(this.email, this.password);
            if (isAuthStatus) window.location.href = '/';
            else this.isFormRequestStatus = false;
        }
    }
}
</script>

<style scoped>
form {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
input, button {
    width: 320px;
    margin: 8px 0;
}
</style>