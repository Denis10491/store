<template>
<div class="uk-flex uk-flex-between">
    <div class="uk-width-1-1">
        <div v-for="product in products" :key="product.id" class="uk-width-1-1" uk-grid>
            <Product
                :data="productsStore.getProductById(product.id)"
                :isAdmin="true"
                :renderFormForUpdateProductById="renderFormForUpdateProductById"
            />
        </div>
    </div>

    <form id="product-form" class="uk-card uk-card-default uk-flex uk-flex-column uk-width-1-2 uk-margin-small-left uk-padding-small uk-height-1-1"
        @submit.prevent="productsStore.create()"
    >
        <h3>{{ titleProductForm }}</h3>
        <div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Name" name="name" v-model="productForm.name" required>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Description" name="description" v-model="productForm.description" required>

            <div class="js-upload uk-placeholder uk-text-center">
                <span uk-icon="icon: cloud-upload"></span>
                <span class="uk-text-middle">Attach binaries by dropping them here or </span>
                <div uk-form-custom>
                    <input type="file" id="img" name="imgPath" required>
                    <span class="uk-link">selecting one</span>
                </div>
            </div>
            <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

            <div class="uk-flex-inline uk-margin-small-bottom">
                <input type="text" class="uk-input" placeholder="Proteins" name="proteins" v-model="productForm.nutritional.proteins" required>
                <input type="text" class="uk-input" placeholder="Fats" name="fats" v-model="productForm.nutritional.fats" required>
                <input type="text" class="uk-input" placeholder="Carbohydrates" name="carbohydrates" v-model="productForm.nutritional.carbohydrates" required>
            </div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Composition" name="composition" v-model="productForm.composition" required>

            <div class="uk-flex">
                <input type="text" class="uk-input uk-margin-small-bottom uk-width-1-2" placeholder="Price" name="price" v-model="productForm.price" required>
                <button class="uk-button uk-button-primary uk-height-1-1 uk-width-1-2">Confirm</button>
            </div>
        </div>
        <div v-if="!isFormRequestStatus" class="uk-alert-danger uk-padding-small">
            <p>Failed to create</p>
        </div>
    </form>
</div>
</template>

<script>
import { useProductsStore } from '../../store/products';
import Product from '../Product.vue';

export default {
    name: 'AdminProductsComponent',
    components: { Product },

    data() {
        return {
            titleProductForm: 'Create product',
            productForm: {
                name: "",
                description: "",
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
        renderFormForUpdateProductById(data) {
            this.titleProductForm = 'Update product';
            const product = this.productsStore.getProductById(data.id);
            this.updateDataForProductForm(
                product.name, product.description, product.composition,
                product.nutritional.proteins, product.nutritional.fats, product.nutritional.carbohydrates, 
                product.price
            );
        },

        updateDataForProductForm(
            name = "", description = "", composition = "",
            proteins = "", fats = "", carbohydrates = "", price  =""
        ) {
            this.productForm = {
                name: name,
                description: description,
                composition: composition,
                nutritional: {
                    proteins: proteins,
                    fats: fats,
                    carbohydrates: carbohydrates
                },
                price: price
            }
        },
        
        fileLoader() {
            let bar = document.getElementById('js-progressbar');
            UIkit.upload('.js-upload', {
                url: '',
                multiple: true,

                loadStart: function (e) {
                    bar.removeAttribute('hidden');
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                progress: function (e) {
                    bar.max = e.total;
                    bar.value = e.loaded;
                },loadEnd: function (e) {
                    bar.max = e.total;
                    bar.value = e.loaded;
                },

                completeAll: function () {

                    setTimeout(function () {
                        bar.setAttribute('hidden', 'hidden');
                    }, 1000);
                }
            });
        }
    },

    computed: {
        products() {
            return this.productsStore.list;
        },
        productsInBasket() {
            return this.productsStore.listInBasket;
        }
    },

    mounted() {
        this.fileLoader();
        this.updateDataForProductForm();
    }
}
</script>