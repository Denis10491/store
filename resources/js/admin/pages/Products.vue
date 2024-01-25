<template>
<div id="open-form-product" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical border" style="overflow: hidden;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header uk-flex uk-flex-center uk-flex-middle">
            <p class="uk-modal-title">Update product</p>
        </div>
        <ProductForm :type="'update'" :id="computedSelectedProductId" :page="currentPage" />
    </div>
</div>

<div>
    <ul uk-tab>
        <li :class="{'uk-active': menu.cards}"><a @click="changeTab('list')" href="#">list</a></li>
        <li :class="{'uk-active': menu.table}"><a @click="changeTab('table')" href="#">table</a></li>
        <li :class="{'uk-active': menu.create}"><a @click="changeTab('create')" href="#">create</a></li>
    </ul>
</div>
<div v-if="loaded">
    <div v-show="menu.list" class="uk-width-1-1">
        <div v-for="product in products[currentPage]" :key="product.id" class="uk-width-1-1" uk-grid>
            <Product
                :data="product"
                :page="currentPage"
            />
        </div>
    </div>

    <table v-show="menu.table" class="uk-table uk-table-divider uk-table-middle uk-table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Description</th>
                <th>Composition</th>
                <th>Proteins</th>
                <th>Fats</th>
                <th>Carbohydrates</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products[currentPage]" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.composition }}</td>
                <td>{{ product.nutritional.proteins }}</td>
                <td>{{ product.nutritional.fats }}</td>
                <td>{{ product.nutritional.carbohydrates }}</td>
                <td>{{ product.price }}</td>
                <td class="uk-align-center">
                    <a class="uk-button uk-button-primary" 
                        href="#open-form-product" 
                        @click="productsStore.selectedId = product.id"
                        uk-toggle
                    >Update</a>
                    <button class="uk-button uk-button-danger uk-margin-small-top" 
                        @click="productsStore.deleteFromDB(product.id, currentPage)"
                    >Remove</button>
                </td>
            </tr>
        </tbody>
    </table>

    <Paginator
        v-show="menu.list || menu.table"
        :currentPage="currentPage"
        :changePage="changePage"
        :numOfMaxPage="productsStore.numOfMaxPage"
    />

    <ProductForm v-show="menu.create" :type="'create'" :page="1" />
</div>

<div v-else class="uk-padding-small">
    <p>Loading...</p>
</div>
</template>

<script>
import ProductForm from '../components/Product.Form.vue';
import { useProductsStore } from '../store/products';
import Product from '../components/Product.vue';
import Paginator from '../../components/Paginator.vue';

export default {
    name: 'AdminProductsComponent',
    components: { Product, ProductForm, Paginator },

    data() {
        return {
            menu: {
                list: true,
                table: false,
                create: false
            },
            loaded: true,
            currentPage: 1,
        }
    },

    setup() {
        const productsStore = useProductsStore();
        return { productsStore }
    },

    methods: {
        changeTab(name) {
            Object.keys(this.menu).map(key => {
                this.menu[key] = false
                if (key == name) this.menu[key] = true;
            });
        },

        changePage(num) {
            this.loaded = false;
            this.productsStore.getPage(num);
            setTimeout(() => {
                (this.productsStore.numOfMaxPage < num)
                ? this.currentPage = this.productsStore.numOfMaxPage
                : this.currentPage = num;
                this.loaded = true;
            }, 500);
        }
    },

    computed: {
        products() {
            return this.productsStore.list;
        }
    },

    async mounted() {
        this.loaded = await this.productsStore.getPage(1);
    }
}
</script>

<style scoped>
.product-form-header h3 {
    margin: 0;
}
.uk-table th {
    text-align: start;
}
.uk-modal-close-default {
    left: inherit;
    top: 20px;
    right: 20px;
}
</style>