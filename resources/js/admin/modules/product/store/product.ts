import {defineStore} from "pinia";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import type {IProduct} from "@admin/modules/product/interfaces/IProduct";

export const useProductStore = defineStore('product', {
    state: () => ({
        list: [] as Array<IMinifiedProduct>,
        selectedProduct: {} as IProduct
    }),

    getters: {
        getList(): Array<IMinifiedProduct> {
            return this.list
        }
    }
})
