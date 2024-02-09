<script setup lang="ts">
import Header from './components/layout/Header.vue'
import Message from './components/layout/Message.vue'
</script>

<template>
    <main class="main container">
        <Header></Header>
        <div class="content">
            <router-view></router-view>
        </div>
    </main>
    <Message />
</template>