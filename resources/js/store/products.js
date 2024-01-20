import axios from "axios";
import { defineStore } from "pinia";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [],
        listInBasket: JSON.parse(localStorage.getItem('basket') ?? "{}"),
        token: 'Bearer ' + sessionStorage.getItem('token')
    }),

    actions: {
        async create(product) {
            console.log(product)
            // return axios.post('/products/store', {
            //     name: name, description: description
            // }, {
            //     headers: {
            //         Authorization: token
            //     }
            // })
            // .then(() => true)
            // .catch(() => false)
        },

        addToBasket(id, type) {
            if (!this.listInBasket[id]) this.listInBasket[id] = {
                id: id,
                count: 0
            }
            if (type == '+') this.listInBasket[id]["count"]++;
            else if (--this.listInBasket[id]["count"] == 0) delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        async deleteFromDB(productId) {
            const response = await axios.delete('/products/destroy/'+productId, {
                headers: {
                    Authorization: this.token
                }
            });
            if (response) this.getAll()
        },

        removeById(id) {
            delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        async getAll() {
            const response = await axios.get('/products/index');
            this.list = response.data.data.map(item => {
                item["count"] = 0; return item;
            });
        },

        getProductById(id) {
            return this.list.find(product => product.id == id);
        },

        getProductInBasketById(id) {
            return this.listInBasket[id];
        }
    }
});