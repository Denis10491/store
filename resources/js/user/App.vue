<script setup lang="ts">
import Header from '@user/components/Header.vue'
import Message from '@user/components/Message.vue'
</script>

<template>
    <main class="main container">
        <Header></Header>
        <div class="content">
            <router-view></router-view>
        </div>
    </main>
    <Message/>
</template>
