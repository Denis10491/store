import {defineStore} from "pinia";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";

export const useProductsStore = defineStore('product', {
    state: () => ({
        list: [] as Array<IMinifiedProduct>
    }),

    getters: {
        getList(): Array<IMinifiedProduct> {
            return this.list
        }
    }
})
