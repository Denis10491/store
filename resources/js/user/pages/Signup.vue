<template>
    <div class="uk-flex uk-flex-center container">
        <form class="uk-card uk-card-default uk-padding border" @submit.prevent="send()">
            <h3>Create new account</h3>
            <input type="text" class="uk-input" placeholder="Name" v-model="data.name">
            <input type="email" class="uk-input" placeholder="Email" v-model="data.email">
            <input type="password" class="uk-input" placeholder="Password" v-model="data.password">
            <button class="uk-button uk-background-primary uk-light">SignUp</button>
            <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
                <p>We cannot register you. Try again</p>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { UserData } from '../../helpers/interfaces';
import { signup } from '../services/api';

let data = reactive<UserData>({
    name: '',
    email: '',
    password: ''
});
let isFormRequestStatus = ref<boolean>(true);

const send = async () => {
    isFormRequestStatus.value = true;
    const isCreatedStatus = await signup(data.name, data.email, data.password);
    if (isCreatedStatus) window.location.href = '/login';
    else isFormRequestStatus.value = false;
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