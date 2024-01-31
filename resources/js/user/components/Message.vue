<template>
    <div v-if="isActive" class="message uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle uk-padding-small border">
        <p>We would like to inform you that this online store is not a real commercial project</p>
        <div class="uk-flex uk-flex-middle uk-margin-small-left">
            <router-link to="/about" class="uk-button uk-button-default">Read more</router-link>
            <button class="uk-button uk-button-primary uk-margin-small-left" @click="isActive = false">Ok</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isActive: false
        }
    },

    mounted() {
        setTimeout(() => this.isActive = true, 2000);
    }
}
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