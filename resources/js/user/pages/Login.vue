<template>
    <div class="uk-flex uk-flex-center">
        <Card>
            <h3>Login to your account</h3>
            <Input type="email" placeholder="Email" v-model="data.email" />
            <Input type="password" placeholder="Password" v-model="data.password" />
            <Button type="primary" @click="send()">LogIn</Button>
            <Error v-if="!isFormRequestStatus">Error. Incorrect data entered</Error>
        </Card>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { UserData } from '@helpers/interfaces';
import { login } from '@user/services/api';
import Card from '@components/Card.vue';
import Input from '@components/Input.vue';
import Button from '@components/Button.vue';
import Error from '@components/Error.vue';

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