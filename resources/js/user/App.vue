<template>
    <main class="main container">
        <Header></Header>
        <div class="content">
            <router-view></router-view>
        </div>
    </main>
    <Message />
</template>

<script setup lang="ts">
import Header from '@user/components/layout/Header.vue'
import Message from '@user/components/layout/Message.vue'
</script>