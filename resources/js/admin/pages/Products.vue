<script setup lang="ts">
import {computed, ref} from "vue";
import ProductList from "@admin/modules/product/views/ProductList.vue";
import ProductTable from "@admin/modules/product/views/ProductTable.vue";
import CreateProductForm from "@admin/modules/product/views/CreateProductForm.vue";
import {useProductStore} from "@admin/modules/product/store/product";
import {Product} from "@admin/modules/product/services/product";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import Modal from "@components/Modal.vue";
import Card from "@ui/Card.vue";
import UpdateProductForm from "@admin/modules/product/views/UpdateProductForm.vue";

let menu = ref({
    list: true,
    table: false
})

Product.getAll()
const productStore = useProductStore()
const products = computed<Array<IMinifiedProduct>>(() => productStore.getList)

const changeTab = (name: string) => Object.keys(menu.value).map((key: string) => menu.value[key] = key === name)
</script>

<template>
    <Modal id="update-product" title="Update product">
        <UpdateProductForm/>
    </Modal>
    <Modal id="create-product" title="Create product">
        <CreateProductForm/>
    </Modal>

    <div>
        <ul uk-tab>
            <li :class="{'uk-active': menu.list}"><a @click="changeTab('list')" href="#">list</a></li>
            <li :class="{'uk-active': menu.table}"><a @click="changeTab('table')" href="#">table</a></li>
            <li><a uk-toggle href="#create-product">create</a></li>
        </ul>
    </div>

    <div v-if="products.length > 0">
        <ProductList v-if="menu.list"/>
        <ProductTable v-if="menu.table"/>
    </div>
    <Card v-else>Loading...</Card>
</template>
