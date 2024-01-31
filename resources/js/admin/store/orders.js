import { defineStore } from "pinia";
import axios from 'axios'

export const useOrdersStore = defineStore('orders', {
    state: () => ({
        list: [],
        filteredList: [],
        token: 'Bearer ' + sessionStorage.getItem('token') ?? "",
        maxPerPage: 0,
        count: 0,
        countForFilteredList: 0
    }),

    getters: {
        numOfMaxPage() {
            return Math.round(this.countForFilteredList / this.maxPerPage) + 1;
        }
    },

    actions: {
        async getPage(num) {
            const response = await axios.get('/orders/index/'+num, {
                headers: {
                    Authorization: this.token
                }
            });
            if (response) {
                this.list[num] = await response.data.data.data;
                this.filteredList[num] = await response.data.data.data;
                this.maxPerPage = await response.data.data.per_page;
                this.count = await response.data.data.total;
                this.countForFilteredList = await response.data.data.total;
                return true;
            }
            return false;
        },


        filter(dateStart = null, dateEnd = null, productName = null) {
            let stashListOrders = [];

            // Date Start
            if (dateStart) {
                let filterDateStart = new Date(dateStart);
                this.list.map(page => {
                    page.map(order => {
                        let currentDate = new Date(order.created_at);
                        if (
                            currentDate.getFullYear() >= filterDateStart.getFullYear() &&
                            this.getMonth(currentDate) >= filterDateStart.getMonth() &&
                            currentDate.getDate() >= filterDateStart.getDate()
                        ) stashListOrders.push(order)
                    })
                });
            }

            // Date End
            if (dateEnd) {
                let filterDateEnd = new Date(dateEnd);
                this.list.map(page => {
                    page.map(order => {
                        let currentDate = new Date(order.created_at);
                        if (
                            currentDate.getFullYear() <= filterDateEnd.getFullYear() &&
                            this.getMonth(currentDate) <= filterDateEnd.getMonth() &&
                            currentDate.getDate() <= filterDateEnd.getDate()
                        ) stashListOrders.push(order);
                    });
                });
            }

            // Products
            if (productName) {
                this.list.map(page => {
                    page.map(order => {
                        if (order.products.find(product => product.name.includes(productName))) stashListOrders.push(order);
                    });
                });
            }

            if (stashListOrders.length == 0) this.filteredList = this.list;
            else {
                this.filteredList = [];
                for (let i = 1; i < stashListOrders.length; i += this.maxPerPage) {
                    this.filteredList[i] = stashListOrders.slice(i, i + this.maxPerPage);
                }
                this.countForFilteredList = this.filteredList.length
            }
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