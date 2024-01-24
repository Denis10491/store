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