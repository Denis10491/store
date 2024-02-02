import axios from "axios";
import { defineStore } from "pinia";

export const useProductsStore = defineStore('products', {

    state: () => ({
        list: [],
        token: 'Bearer ' + sessionStorage.getItem('token'),
        maxPerPage: 0,
        count: 0,
        selectedId: null
    }),

    getters: {
        numOfMaxPage() {
            return Math.round(this.count / this.maxPerPage) + 1;
        }
    },

    actions: {
        create(form) {
            const formData = new FormData();
        
            formData.append('name', form.name);
            formData.append('description', form.description);
            formData.append('image', form.img);
            formData.append('proteins', form.nutritional.proteins);
            formData.append('fats', form.nutritional.fats);
            formData.append('carbohydrates', form.nutritional.carbohydrates);
            formData.append('composition', form.composition);
            formData.append('price', form.price);
        
            return axios.post('/products', formData, {
                headers: {
                    Authorization: this.token,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => {
                this.getAll();
                return true;
            })
            .catch(() => false)
        },
        
        update(form) {
            const formData = new FormData();
        
            if (form.img) formData.append('image', form.img);
            formData.append('name', form.name);
            formData.append('description', form.description);
            formData.append('proteins', form.nutritional.proteins);
            formData.append('fats', form.nutritional.fats);
            formData.append('carbohydrates', form.nutritional.carbohydrates);
            formData.append('composition', form.composition);
            formData.append('price', form.price);
        
            return axios.post('/products/update/'+form.id, formData, {
                headers: {
                    Authorization: this.token,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => true)
            .catch(() => false)
        },

        deleteFromDB(productId, page = null) {
            return axios.delete('/products/destroy/'+productId, {
                headers: {
                    Authorization: this.token
                }
            })
            .then(() => {
                if (page) this.getPage(page);
                return true;
            })
            .catch(() => false)
        },

        async getPage(num) {
            const response = await axios.get('/products/page/'+num);
            if(!response) return false;
            this.list[num] = await response.data.data.data;
            this.maxPerPage = await response.data.data.per_page;
            this.count = await response.data.data.total;
            return true;
        },

        getProductById(id) {
            let product = null
            this.list.forEach(page => {
                product = page.find(product => product.id == id);  
            })
            return product
        }
    }
});