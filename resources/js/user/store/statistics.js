import { defineStore } from "pinia";

export const useStatisticsStore = defineStore('statistics', {

    state: () => ({
        ordersInSelectedMonth: [],
        bestSelling: {},
        token: 'Bearer ' + sessionStorage.getItem('token') ?? ""
    }),

    actions: {
        async getCountOfOrders(year, month) {
            const response = await axios.get('/statistics/orders/count?year='+year+'&month='+month, {
                headers: {
                    Authorization: this.token
                }
            });
            this.ordersInSelectedMonth = await response.data.data;
        },

        async getBestSellingProducts(year, month) {
            const response = await axios.get('/statistics/products/bestselling?year='+year+'&month='+month, {
                headers: {
                    Authorization: this.token
                }
            });
            let products = await response.data.data;
            this.bestSelling = await products;
        }
    }
})