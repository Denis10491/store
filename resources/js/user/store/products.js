import axios from "axios";
import { defineStore } from "pinia";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [],
        listInBasket: JSON.parse(localStorage.getItem('basket') ?? "{}"),
        token: 'Bearer ' + sessionStorage.getItem('token'),
        maxPerPage: 0,
        count: 0
    }),

    getters: {
        numOfMaxPage() {
            return Math.round(this.count / this.maxPerPage) + 1;
        }
    },

    actions: {
        addToBasket(id, type) {
            if (!this.listInBasket[id]) this.listInBasket[id] = {
                id: id,
                count: 0
            }
            if (type == '+') this.listInBasket[id]["count"]++;
            else if (--this.listInBasket[id]["count"] == 0) delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        removeById(id) {
            delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        async getPage(num) {
            const response = await axios.get('/products/index/'+num);
            this.list[num] = await response.data.data.data.map(item => {
                item["count"] = 0; return item;
            });
            this.maxPerPage = await response.data.data.per_page;
            this.count = await response.data.data.total;
        },

        getProductById(id) {
            let product = null
            this.list.forEach(page => {
                product = page.find(product => product.id == id);  
            })
            return product
        },

        getProductInBasketById(id) {
            return this.listInBasket[id];
        }
    }
});