import {defineStore} from "pinia";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";

export const useProductStore = defineStore('product', {
    state: () => ({
        list: [] as Array<IMinifiedProduct>,
        selectedId: NaN
    }),

    getters: {
        getList(): Array<IMinifiedProduct> {
            return this.list
        }
    }
})
