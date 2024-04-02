<template>
    <Card v-if="isActive"
          class="message uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle uk-padding-small border">
        <p>We would like to inform you that this online store is not a real commercial project</p>
        <div class="uk-flex uk-flex-middle uk-margin-small-left">
            <router-link to="/about">
                <Button type="default">Read more</Button>
            </router-link>
            <Button type="primary" class="uk-margin-small-left" @click="isActive = false">Ok</Button>
        </div>
    </Card>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import Button from "@ui/Button.vue";

const isActive = ref<boolean>(false);
onMounted(() => setTimeout(() => isActive.value = true, 2000));
</script>

<style scoped>
.message {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 80px);
}

.message * {
    margin: 0;
}
</style>
