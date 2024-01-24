<template>

<div>
    <ul uk-tab>
        <li :class="{'uk-active': menu.cards}"><a @click="changeTab('list')" href="#">list</a></li>
        <li :class="{'uk-active': menu.create}"><a @click="changeTab('create')" href="#">create</a></li>
    </ul>
</div>
<div v-if="loaded">
    <div v-show="menu.list" class="uk-width-1-1">
        <div v-for="product in products[currentPage]" :key="product.id" class="uk-width-1-1" uk-grid>
            <Product
                :data="product"
                :isAdmin="true"
                :renderFormProductById="renderFormProductById"
                :page="currentPage"
            />
        </div>
        <Paginator
            :currentPage="currentPage"
            :changePage="changePage"
            :numOfMaxPage="productsStore.numOfMaxPage"
        />
    </div>

    <form v-show="menu.create" id="product-form" class="border uk-card uk-card-default uk-flex uk-flex-column uk-width-1-2 uk-margin-small-left uk-padding uk-height-1-1"
        @submit.prevent="send()"
    >
        <div class="product-form-header uk-flex uk-flex-between uk-margin-small-bottom">
            <h3>{{ titleProductForm }}</h3>
            <button class="uk-button uk-button-default uk-flex-center" 
                v-if="titleProductForm == 'Update product'"
                @click.prevent="renderFormProductById()"
            >Вернуться к созданию</button>
        </div>
        <div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Name" v-model="productForm.name">
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Description" v-model="productForm.description">

            <div uk-form-custom="target: true">
                <input type="file" aria-label="Custom controls" @change="fileLoad">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" aria-label="Custom controls" disabled>
            </div>

            <div class="uk-flex-inline uk-margin-small-top uk-margin-small-bottom">
                <input type="text" class="uk-input" placeholder="Proteins" name="proteins" v-model="productForm.nutritional.proteins">
                <input type="text" class="uk-input" placeholder="Fats" name="fats" v-model="productForm.nutritional.fats">
                <input type="text" class="uk-input" placeholder="Carbohydrates" name="carbohydrates" v-model="productForm.nutritional.carbohydrates">
            </div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Composition" v-model="productForm.composition">

            <div class="uk-flex">
                <input type="text" class="uk-input uk-margin-small-bottom uk-width-1-2" placeholder="Price" v-model="productForm.price">
                <button class="uk-button uk-button-primary uk-height-1-1 uk-width-1-2">Confirm</button>
            </div>
        </div>
        <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
            <p>Failed</p>
        </div>
    </form>
</div>
<div v-else class="uk-padding-small">
    <p>Loading...</p>
</div>
</template>

<script>
import { useProductsStore } from '../store/products';
import Product from '../components/Product.vue';
import Paginator from '../../components/Paginator.vue';

export default {
    name: 'AdminProductsComponent',
    components: { Product, Paginator },

    data() {
        return {
            menu: {
                list: true,
                create: false
            },
            loaded: true,
            currentPage: 1,
            titleProductForm: 'Create product',
            productForm: {
                id: null,
                name: "",
                description: "",
                img: null,
                composition: "",
                nutritional: {
                    proteins: "",
                    fats: "",
                    carbohydrates: ""
                },
                price: ""
            },
            isFormRequestStatus: true
        }
    },

    setup() {
        const productsStore = useProductsStore();
        return { productsStore }
    },

    methods: {
        async send() {
            (this.titleProductForm == 'Create product') 
            ? this.isFormRequestStatus = await this.productsStore.create(this.productForm)
            : this.isFormRequestStatus = await this.productsStore.update(this.productForm);
            if (this.isFormRequestStatus) this.productsStore.getPage(this.currentPage);

        },

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
        },

        renderFormProductById(data = null) {
            (this.titleProductForm == 'Update product') 
            ? this.titleProductForm = 'Create product'
            : this.titleProductForm = 'Update product'
            
            if (data) {
                const product = this.productsStore.getProductById(data.id);
                this.productForm.id = data.id;
                this.updateDataForProductForm(
                    data.id, product.name, product.description, null,
                    product.composition, product.nutritional.proteins, 
                    product.nutritional.fats, product.nutritional.carbohydrates, 
                    product.price
                );
            }
            else this.updateDataForProductForm();
        },

        updateDataForProductForm(
            id = null, name = "", description = "", img = null, composition = "",
            proteins = "", fats = "", carbohydrates = "", price = ""
        ) {
            this.productForm = {
                id: id,
                name: name,
                description: description,
                img: img,
                composition: composition,
                nutritional: {
                    proteins: proteins,
                    fats: fats,
                    carbohydrates: carbohydrates
                },
                price: price
            }
        },

        fileLoad(e) {
            this.productForm.img = e.target.files[0];
        }
    },

    computed: {
        products() {
            return this.productsStore.list;
        }
    },

    async mounted() {
        this.updateDataForProductForm();
        this.loaded = await this.productsStore.getPage(1);
    }
}
</script>

<style scope>
.product-form-header h3 {
    margin: 0;
}
</style>