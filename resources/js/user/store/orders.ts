import { defineStore } from "pinia";
import { pageOfOrders } from "@user/services/api";
import { ArrayOrder } from "@helpers/interfaces";
import { getMonth } from "@helpers/functions";

export const useOrdersStore = defineStore('orders', {
    state: () => ({
        list: [] as ArrayOrder,
        filteredList: [] as ArrayOrder,
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getList(): ArrayOrder {
            return this.list;
        },
        getLastPage(): number {
            return this.lastPage;
        }
    },

    actions: {
        filter(dateStart: string | null = null, dateEnd: string | null = null, productName: string | null = null) {
            this.filteredList = this.list;

            // Date Start
            if (dateStart) {
                let filterDateStart = new Date(dateStart);
                this.filteredList = this.filteredList.map(page => {
                    return page.filter((order: { created_at: string | Date; }) => {
                        let currentDate = new Date(order.created_at);
                        return (
                            currentDate.getFullYear() >= filterDateStart.getFullYear() &&
                            getMonth(currentDate) >= filterDateStart.getMonth() &&
                            currentDate.getDate() >= filterDateStart.getDate()
                        ) ? true : false;
                    });
                });
            }

            // Date End
            if (dateEnd) {
                let filterDateEnd = new Date(dateEnd);
                this.filteredList = this.filteredList.map((page: any[]) => {
                    return page.filter((order: { created_at: string | Date; }) => {
                        let currentDate = new Date(order.created_at);
                        return (
                            currentDate.getFullYear() <= filterDateEnd.getFullYear() &&
                            getMonth(currentDate) <= filterDateEnd.getMonth() &&
                            currentDate.getDate() <= filterDateEnd.getDate()
                        ) ? true : false;
                    });
                });
            }

            // Products
            if (productName) {
                this.filteredList = this.filteredList.map((page: any[]) => {
                    return page.filter((order: { products: any[]; }) => {
                        return (order.products.find((product: { name: string }) => product.name.includes(productName))) ? true : false;
                    });
                });
            }
        },

        async getPage(num: number) {
            const response = await pageOfOrders(num);
            this.list[num] = await response.orders;
            this.filteredList[num] = await response.orders;
            this.maxPerPage = await response.per_page;
            this.lastPage = await response.lastPage;
            return true;
        }
    }
})