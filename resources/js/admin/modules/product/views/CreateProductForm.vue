<template>
    <div
        class="uk-card uk-card-default uk-flex uk-flex-column uk-width-1-1 uk-padding uk-height-1-1 border"
    >
        <div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Name" v-model="productForm.name">
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Description"
                   v-model="productForm.description">

            <div uk-form-custom="target: true">
                <input type="file" aria-label="Custom controls" @change="fileLoad">
                <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file"
                       aria-label="Custom controls" disabled>
            </div>

            <div class="uk-flex-inline uk-margin-small-top uk-margin-small-bottom">
                <input type="text" class="uk-input" placeholder="Proteins" name="proteins"
                       v-model="productForm.nutritional.proteins">
                <input type="text" class="uk-input" placeholder="Fats" name="fats"
                       v-model="productForm.nutritional.fats">
                <input type="text" class="uk-input" placeholder="Carbohydrates" name="carbohydrates"
                       v-model="productForm.nutritional.carbohydrates">
            </div>
            <input type="text" class="uk-input uk-margin-small-bottom" placeholder="Composition"
                   v-model="productForm.composition">

            <div class="uk-flex">
                <input type="text" class="uk-input uk-margin-small-bottom uk-width-1-2" placeholder="Price"
                       v-model="productForm.price">
                <button
                    v-if="type == 'create'"
                    class="uk-button uk-button-primary uk-height-1-1 uk-width-1-2"
                    @click="create()"
                >Create
                </button>
                <button
                    v-if="type == 'update'"
                    class="uk-button uk-button-primary uk-height-1-1 uk-width-1-2"
                    @click="update()"
                >Update
                </button>
            </div>
        </div>

        <div v-if="isFormRequestStatus == true" class="uk-alert-success" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p>Success</p>
        </div>
        <div v-if="isFormRequestStatus == false" class="uk-alert-danger uk-padding-small">
            <p>Failed</p>
        </div>
    </div>
</template>

<script>
import {useProductsStore} from '../../../store/products.js';

export default {
    name: 'AdminProductFormComponent',
    props: ['type', 'page'],

    data() {
        return {
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
            isFormRequestStatus: null
        }
    },

    setup() {
        const productsStore = useProductsStore();
        return {productsStore}
    },

    methods: {
        async create() {
            this.isFormRequestStatus = await this.productsStore.create(this.productForm)
            if (this.isFormRequestStatus) this.productsStore.getPage(this.currentPage);
        },

        async update() {
            this.isFormRequestStatus = await this.productsStore.update(this.productForm);
            if (this.isFormRequestStatus) {
                this.productsStore.getPage(this.page);
                setTimeout(() => {
                    this.isFormRequestStatus = null
                }, 5000)
            }
        },

        renderFormProductById(data = null) {
            if (data) this.productsStore.selectedId = data.id;
            let product = this.productsStore.getProductById(this.productsStore.selectedId);

            this.updateDataForProductForm(
                this.productsStore.selectedId, product.name, product.description,
                null, product.composition, product.nutritional.proteins,
                product.nutritional.fats, product.nutritional.carbohydrates,
                product.price
            );
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

    watch: {
        'productsStore.$state.selectedId': function (val) {
            if (this.type == 'update') this.renderFormProductById({id: val});
        }
    }
}
</script>

<style scoped>
.uk-modal-title {
    margin: 0;
}
</style>
