<template>
    <main class="main container">
        <Header></Header>
        <div class="content">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
import Header from './components/Header.vue';

export default {
    components: { Header }
}
</script>