<template>
    <div class="uk-flex uk-flex-center container">
        <form class="uk-card uk-card-default uk-padding border" @submit.prevent="send()">
            <h3>Login to your account</h3>
            <input type="email" class="uk-input" placeholder="Email" v-model="email">
            <input type="password" class="uk-input" placeholder="Password" v-model="password">
            <button class="uk-button uk-background-primary uk-light">LogIn</button>
            <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
                <p>Error. Incorrect data entered</p>
            </div>
        </form>
    </div>
</template>

<script>
import { login } from '../services/api'

export default {
    name: 'LoginPage',

    data() {
        return {
            email: "",
            password: "",
            isFormRequestStatus: true
        }
    },

    methods: {
        async send() {
            this.isFormRequestStatus = true;
            const isAuthStatus = await login(this.email, this.password);
            (isAuthStatus) ? window.location.href = '/' : this.isFormRequestStatus = false;
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