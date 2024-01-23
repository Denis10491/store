<template>
    <Header></Header>
    <main class="main container">
        <router-view></router-view>
    </main>
</template>

<script>
import Header from './components/Header.vue';
import { useProductsStore } from './store/products';

export default {
    components: { Header },

    setup() {
        const productsStore = useProductsStore();
        return { productsStore }
    },

    mounted() {
        this.productsStore.getPage(1);
    }
}
</script>