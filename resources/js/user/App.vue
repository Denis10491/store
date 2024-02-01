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
import Header from './components/other/Header.vue'
import Message from './components/other/Message.vue'

export default {
    components: {
        Header, Message
    }
}
</script>