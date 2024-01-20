import { defineStore } from "pinia";
import { useUserStore } from "./user";

export const useOrdersStore = defineStore('orders', {
    state: () => ({
        list: [],
        filteredList: [],
        token: 'Bearer ' + sessionStorage.getItem('token') ?? ""
    }),

    actions: {
        async getAll() {
            const response = await axios.get('/orders/index', {
                headers: {
                    Authorization: this.token
                }
            });
            if (!response) return false;
            this.list = await response.data.data;
            this.filteredList = await response.data.data;
        },

        create(products, address) {
            return axios.post('/orders/store', {
                products: JSON.stringify(products), address: address
            }, {
                headers: {
                    Authorization: this.token
                }
            })
            .then(response => {
                localStorage.removeItem('basket');
                return response;
            })
            .catch(() => false);
        },

        async showByUserId() {
            const response = await axios.get('/orders/show', {
                headers: {
                    Authorization: this.token
                }
            });
            if (!response) return false;
            this.list = await response.data.data;
            this.filteredList = await response.data.data;
        },

        filter(dateStart = null, dateEnd = null, productName = null) {
            // Date Start
            if (dateStart) {
                let filterDateStart = new Date(dateStart);
                this.filteredList = this.filteredList.filter(order => {
                    let currentDate = new Date(order.created_at);
                    return (
                        currentDate.getFullYear() >= filterDateStart.getFullYear() &&
                        this.getMonth(currentDate) >= filterDateStart.getMonth() &&
                        currentDate.getDate() >= filterDateStart.getDate()
                    ) ? true : false;
                });
            }
            // Date End
            if (dateEnd) {
                let filterDateEnd = new Date(dateEnd);
                this.filteredList = this.filteredList.filter(order => {
                    let currentDate = new Date(order.created_at);
                    return (
                        currentDate.getFullYear() <= filterDateEnd.getFullYear() &&
                        this.getMonth(currentDate) <= filterDateEnd.getMonth() &&
                        currentDate.getDate() <= filterDateEnd.getDate()
                    ) ? true : false;
                });
            }
            // Products
            if (productName) {
                this.filteredList = this.filteredList.filter(order => {
                    return order.products.find(product => (product.name.indexOf(productName) > 0));
                });
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
        },
    }
})