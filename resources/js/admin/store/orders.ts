import { defineStore } from "pinia";
import { Order } from "../../helpers/interfaces";
import { pageOfOrders } from "../services/api";

export const useOrdersStore = defineStore('orders', {
    state: () => ({
        list: [] as Array<Order>,
        filteredList: [],
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getList(): Array<Order> {
            return this.list;
        },
        getLastPage() {
            return this.lastPage;
        }
    },

    actions: {
        filter(dateStart = null, dateEnd = null, productName = null) {
            this.filteredList = this.list;

            // Date Start
            if (dateStart) {
                let filterDateStart = new Date(dateStart);
                this.filteredList = this.filteredList.map(page => {
                    return page.filter(order => {
                        let currentDate = new Date(order.created_at);
                        return (
                            currentDate.getFullYear() >= filterDateStart.getFullYear() &&
                            this.getMonth(currentDate) >= filterDateStart.getMonth() &&
                            currentDate.getDate() >= filterDateStart.getDate()
                        ) ? true : false;
                    });
                });
            }

            // Date End
            if (dateEnd) {
                let filterDateEnd = new Date(dateEnd);
                this.filteredList = this.filteredList.map(page => {
                    return page.filter(order => {
                        let currentDate = new Date(order.created_at);
                        return (
                            currentDate.getFullYear() <= filterDateEnd.getFullYear() &&
                            this.getMonth(currentDate) <= filterDateEnd.getMonth() &&
                            currentDate.getDate() <= filterDateEnd.getDate()
                        ) ? true : false;
                    });
                });
            }

            // Products
            if (productName) {
                this.filteredList = this.filteredList.map(page => {
                    return page.filter(order => {
                        return (order.products.find(product => product.name.includes(productName))) ? true : false;
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
        },

        getMonth(date) {
            let dateString = date.toDateString()
            switch(dateString.substring(4).substring(3, dateString.length)) {
                case 'Jan':
                    return 0
                case 'Feb':
                    return 1
                case 'Mar':
                    return 2
                case 'Apr':
                    return 3
                case 'May':
                    return 4
                case 'Jun':
                    return 5
                case 'Jul':
                    return 6
                case 'Aug':
                    return 7
                case 'Sen':
                    return 8
                case 'Oct':
                    return 9
                case 'Nov':
                    return 10
                case 'Dec':
                    return 11
                default:
                    return 0
            }
        }
    }
});