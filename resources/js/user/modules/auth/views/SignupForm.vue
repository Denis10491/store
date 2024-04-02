<script setup lang="ts">
import Button from "@ui/Button.vue";
import Input from "@ui/Input.vue";
import Card from "@ui/Card.vue";
import Error from "@components/Error.vue";
import {reactive, ref} from 'vue';
import type {IUserData} from "@user/modules/auth/interfaces/IUserData";
import {Auth} from "@user/modules/auth/services/auth";

let data = reactive<IUserData>({
    name: '',
    email: '',
    password: ''
})
let isFormRequestStatus = ref<boolean>(true)

const submit = async () => {
    isFormRequestStatus.value = true
    if (await Auth.signup(data.name!, data.email, data.password)) {
        window.location.href = '/login'
    }
    isFormRequestStatus.value = false
}
</script>

<template>
    <div class="uk-flex uk-flex-center">
        <Card>
            <h3>Create new account</h3>
            <Input type="text" placeholder="Name" v-model="data.name" :value="data.name"/>
            <Input type="email" placeholder="Email" v-model="data.email" :value="data.email"/>
            <Input type="password" placeholder="Password" v-model="data.password" :value="data.password"/>
            <Button type="primary" @click="submit()">SignUp</Button>
            <Error v-if="!isFormRequestStatus">We cannot register you. Try again</Error>
        </Card>
    </div>
</template>
