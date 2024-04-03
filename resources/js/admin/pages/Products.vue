<script setup lang="ts">
import {computed, ref} from "vue";
import {useProductStore} from "@admin/modules/product/store/product";
import {Product} from "@admin/modules/product/services/product";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import ProductList from "@admin/modules/product/views/ProductList.vue";
import ProductTable from "@admin/modules/product/views/ProductTable.vue";
import Modal from "@components/Modal.vue";
import Card from "@ui/Card.vue";

let menu = ref({
    list: true,
    table: false
})

Product.getAll()
const productStore = useProductStore()
const products = computed<Array<IMinifiedProduct>>(() => productStore.getList)

const changeTab = (name: string) => {
    Object.keys(menu.value).map((key: string) => {
        menu.value[key] = key === name
    });
}
</script>

<template>
    <Modal title="Update product">
        <!-- UpdateProductForm -->
    </Modal>
    <Modal title="Create product">
        <!-- CreateProductForm -->
    </Modal>

    <div>
        <ul uk-tab>
            <li :class="{'uk-active': menu.list}"><a @click="changeTab('list')" href="#">list</a></li>
            <li :class="{'uk-active': menu.table}"><a @click="changeTab('table')" href="#">table</a></li>
        </ul>
    </div>

    <div v-if="products.length > 0">
        <ProductList v-if="menu.list"/>
        <ProductTable v-if="menu.table"/>
    </div>
    <Card v-else>Loading...</Card>
</template>
