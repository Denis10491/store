<template>
    <div class="uk-flex uk-flex-center">
        <Card>
            <h3>Create new account</h3>
            <Input type="text" placeholder="Name" v-model="data.name"/>
            <Input type="email" placeholder="Email" v-model="data.email"/>
            <Input type="password" placeholder="Password" v-model="data.password"/>
            <Button type="primary" @click="send()">SignUp</Button>
            <Error v-if="!isFormRequestStatus">We cannot register you. Try again</Error>
        </Card>
    </div>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue';
import {UserData} from '@helpers/interfaces';
import {signup} from '@user/services/api';
import Card from '@ui/Card.vue';
import Input from '@ui/Input.vue';
import Button from '@ui/Button.vue';
import Error from '@components/Error.vue';

let data = reactive<UserData>({
    name: '',
    email: '',
    password: ''
});
let isFormRequestStatus = ref<boolean>(true);

const send = async () => {
    isFormRequestStatus.value = true;
    const isCreatedStatus = await signup(data.name!, data.email, data.password);
    if (isCreatedStatus) window.location.href = '/login';
    else isFormRequestStatus.value = false;
}
</script>
