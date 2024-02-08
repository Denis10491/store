import { defineStore } from "pinia";
import { Product } from "../../helpers/interfaces";
import { pageOfProducts } from "../services/api";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [] as Array<Product>,
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getLastPage(): number {
            return this.lastPage;
        },
        getList(): Array<Product> {
            return this.list;
        }
    },


    actions: {
        async getPage(num: number) {
            const response = await pageOfProducts(num);
            this.maxPerPage = await response.per_page;
            this.lastPage = await response.last_page;
            this.list[num] = await response.products;;
        },

        getProductById(id: any) {
            let product = null;
            this.list.forEach((page: any[]) => {
                product = page.find((product: { id: any; }) => product.id == id);  
            })
            return product;
        }
    }
});