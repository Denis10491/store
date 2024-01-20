<template>
    <form class="uk-card uk-card-default uk-padding" @submit.prevent="send()">
        <h3>Create new account</h3>
        <input type="text" class="uk-input" placeholder="Name" v-model="name">
        <input type="email" class="uk-input" placeholder="Email" v-model="email">
        <input type="password" class="uk-input" placeholder="Password" v-model="password">
        <button class="uk-button uk-background-primary uk-light">SignUp</button>
        <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
            <p>We cannot register you. Try again</p>
        </div>
    </form>
</template>

<script>
import { useAuthStore } from '../store/auth';

export default {
    name: 'SignupPage',

    data() {
        return {
            name: "",
            email: "",
            password: "",
            isFormRequestStatus: true
        }
    },

    setup() {
        const authStore = useAuthStore();
        return { authStore }
    },

    methods: {
        async send() {
            this.isFormRequestStatus = true;
            const isCreatedStatus = await this.authStore.signup(this.name, this.email, this.password);
            if (isCreatedStatus) window.location.href = '/login';
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