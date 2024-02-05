import { defineStore } from "pinia";
import { Product } from "../../helpers/interfaces";
import { pageOfProducts, productById } from "../services/api";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [] as Array<Product>,
        listInBasket: {},
        sumPriceInBasket: 0,
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getLastPage(): number {
            return this.lastPage;
        },
        getList(): Array<Product> {
            return this.list;
        },
        getListInBasket(): object {
            if (Object.keys(this.listInBasket).length == 0) this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? "{}");
            return this.listInBasket ?? {};
        },
        getSumPriceInBasket(): number {
            return this.sumPriceInBasket ?? 0;
        }
    },

    actions: {
        addToBasket(id: string | number, type: string, price = 0): void {
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
            this.lastPage = await response.last_page;
            this.list[num] = await response.products.map((item: { [x: string]: number; }) => {
                item["count"] = 0; return item;
            });
        },

        async getProductById(id: string | number): Promise<any> {
            const product = await productById(id);
            return await product;
        },

        getProductInBasketById(id: string | number): object {
            if (Object.keys(this.listInBasket).length == 0) this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? "{}");
            return this.listInBasket[id];
        },

        removeById(id: string | number, price = 0): void {
            this.sumPriceInBasket -= this.listInBasket[id]["count"] * price;
            delete this.listInBasket[id];
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        }
    }
});