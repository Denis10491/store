import { defineStore } from "pinia";
import { Product, ArrayProduct } from "@helpers/interfaces";
import { pageOfProducts } from "@admin/services/api";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [] as ArrayProduct,
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getLastPage(): number {
            return this.lastPage;
        },
        getList(): ArrayProduct {
            return this.list;
        }
    },


    actions: {
        async getPage(page: number): Promise<void> {
            const response = await pageOfProducts(page);
            this.maxPerPage = await response.per_page;
            this.lastPage = await response.last_page;
            this.list[page] = await response.products;
        },

        getProductById(id: number): Product | null {
            let product: Product | null = null;
            this.list.forEach(page => {
                let stashProduct = page.find((item: Product) => item.id === id);
                if (stashProduct) product = stashProduct;
            });
            return product;
        }
    }
});