import { defineStore } from "pinia";

export const useOrdersStore = defineStore('orders', {
    state: () => ({
        list: [],
        filteredList: [],
        token: 'Bearer ' + sessionStorage.getItem('token') ?? "",
        maxPerPage: 0,
        count: 0
    }),

    actions: {
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

        async getPage(num) {
            const response = await axios.get('/orders/show/'+num, {
                headers: {
                    Authorization: this.token
                }
            });
            if (!response) return false;
            this.list[num] = await response.data.data.data;
            this.filteredList[num] = await response.data.data.data;
            this.maxPerPage = await response.data.data.per_page;
            this.count = await response.data.data.total;
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
})