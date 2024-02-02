<template>
    <div class="uk-flex uk-flex-center container">
        <form class="uk-card uk-card-default uk-padding border" @submit.prevent="send()">
            <h3>Login to your account</h3>
            <input type="email" class="uk-input" placeholder="Email" v-model="data.email">
            <input type="password" class="uk-input" placeholder="Password" v-model="data.password">
            <button class="uk-button uk-background-primary uk-light">LogIn</button>
            <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
                <p>Error. Incorrect data entered</p>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { login } from '../services/api'
import { reactive, ref } from 'vue';
import { UserData } from '../../helpers/interfaces';

let data = reactive<UserData>({
  email: '',
  password: '',
});
let isFormRequestStatus = ref<boolean>(true);

const send = async () => {
    isFormRequestStatus.value = true;
    const isAuthStatus = await login(data.email, data.password);
    (isAuthStatus) ? window.location.href = '/' : isFormRequestStatus.value = false;
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