import { defineStore } from "pinia";
import { Product } from "../../helpers/interfaces";
import { pageOfProducts, productById } from "../services/api";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [] as Array<Product>,
        listInBasket: {},
        sumPriceInBasket: 0,
        maxPerPage: 0,
        count: 0
    }),

    getters: {
        numOfMaxPage() {
            return Math.round(this.count / this.maxPerPage) + 1;
        },
        getList(): Array<Product> {
            return this.list;
        },
        getListInBasket() {
            if (Object.keys(this.listInBasket).length == 0) this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? "{}");
            return this.listInBasket ?? {};
        },
        getSumPriceInBasket() {
            return this.sumPriceInBasket ?? 0;
        }
    },

    actions: {
        addToBasket(id: string | number, type: string, price = 0) {
            this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? "{}");
            if (!this.listInBasket[id]) this.listInBasket[id] = { id: id, count: 0 }
            if (type == '+') {
                this.listInBasket[id]["count"]++;
                this.sumPriceInBasket += price
            }
            else if (type == '-') {
                this.listInBasket[id]["count"]--;
                this.sumPriceInBasket -= price
            }
            if (this.listInBasket[id]["count"] == 0) delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        async getPage(num: number) {
            const response = await pageOfProducts(num);
            this.maxPerPage = await response.per_page;
            this.count = await response.total;
            this.list[num] = await response.data.map((item: { [x: string]: number; }) => {
                item["count"] = 0; return item;
            });
        },

        async getProductById(id: string | number) {
            const product = await productById(id);
            return await product;
        },

        getProductInBasketById(id: string | number) {
            if (Object.keys(this.listInBasket).length == 0) this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? "{}");
            return this.listInBasket[id];
        },

        removeById(id: string | number, price = 0) {
            this.sumPriceInBasket -= this.listInBasket[id]["count"] * price;
            delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        }
    }
});