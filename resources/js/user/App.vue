<template>
    <main class="main container">
        <Header></Header>

        <div class="content">
            <router-view></router-view>
        </div>
    </main>
    
    <Message></Message>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import Message from './components/Message.vue'

export default {
    components: {
        Header: defineAsyncComponent(() => import('./components/Header.vue')),
        Message
    }
}
</script>