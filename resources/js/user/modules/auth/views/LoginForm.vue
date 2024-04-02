<script setup lang="ts">
import Button from "@ui/Button.vue";
import Error from "@components/Error.vue";
import Input from "@ui/Input.vue";
import Card from "@ui/Card.vue";
import {reactive, ref} from "vue";
import {login} from "@user/services/api";
import type {UserData} from "@user/modules/auth/interfaces/IUserData";

let data = reactive<UserData>({
    email: '',
    password: '',
})
let isFormRequestStatus = ref<boolean>(true)

const submit = async () => {
    isFormRequestStatus.value = true;
    if (await login(data.email, data.password)) {
        window.location.href = '/'
    }
    isFormRequestStatus.value = false;
}
</script>

<template>
    <div class="uk-flex uk-flex-center">
        <Card>
            <h3>Login to your account</h3>
            <Input type="email" placeholder="Email" v-model="data.email" :value="data.email"/>
            <Input type="password" placeholder="Password" v-model="data.password" :value="data.password"/>
            <Button type="primary" @click="submit()">LogIn</Button>
            <Error v-if="!isFormRequestStatus">Error. Incorrect data entered</Error>
        </Card>
    </div>
</template>

<style scoped>

</style>
