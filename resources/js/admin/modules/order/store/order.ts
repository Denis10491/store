import {defineStore} from "pinia";
import type {IOrder} from "@admin/modules/order/interfaces/IOrder";

export const useOrderStore = defineStore('order', {
    state: () => ({
        list: [] as Array<IOrder>
    }),

    getters: {
        getList(): Array<IOrder> {
            return this.list
        }
    }
})
