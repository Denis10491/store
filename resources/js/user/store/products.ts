import { defineStore } from "pinia";
import { Product, ArrayProduct } from "../../helpers/interfaces";
import { pageOfProducts, productById } from "../services/api";

export const useProductsStore = defineStore('products', {
    state: () => ({
        list: [] as ArrayProduct,
        listInBasket: [] as Array<Product>,
        maxPerPage: 0,
        lastPage: 0
    }),

    getters: {
        getLastPage(): number {
            return this.lastPage;
        },
        getList(): ArrayProduct {
            return this.list;
        },
        getListInBasket(): Array<Product> {
            if (Object.keys(this.listInBasket).length === 0) {
                this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? '[]');
            }
            return this.listInBasket;
        },
        getSumPriceInBasket(): number {
            let sum = 0;
            this.listInBasket.forEach(item => sum += item.price * item.count! ?? 1)
            return sum;
        }
    },

    actions: {
        async getPage(page: number): Promise<void> {
            const response = await pageOfProducts(page);
            this.maxPerPage = await response.per_page;
            this.lastPage = await response.last_page;
            this.list[page] = await response.products;
        },

        getProductById(id: number): Product | null {
            let product: Product | null = null;
            this.list.forEach(page => {
                let stashProduct = page.find((item: Product) => item.id === id);
                if (stashProduct) product = stashProduct;
            });
            return product;
        },

        getProductInBasketById(id: number): Product {
            const index = this.getIndexProductInBasketById(id);
            return this.listInBasket[index];
        },

        getIndexProductInBasketById(id: number): number {
            if (Object.keys(this.listInBasket).length === 0) {
                this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? '[]');
            }
            return this.listInBasket.findIndex(item => item.id == id);
        },

        plus(id: number): void {
            this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? '[]');
            const index = this.getIndexProductInBasketById(id);
            if (index === -1) {
                productById(id).then((product: Product) => {
                    product.count = 1;
                    this.listInBasket.push(product);
                    localStorage.setItem('basket', JSON.stringify(this.listInBasket));
                });
            }
            else this.listInBasket[index].count! += 1;
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        minus(id: number): void {
            this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? '[]');
            const index = this.getIndexProductInBasketById(id);
            if (index === -1) {
                let product = this.getProductById(id)!;
                product.count = 1;
                this.listInBasket.push(product);
            }
            else {
                if (this.listInBasket[index].count! === 1) this.listInBasket.splice(index, 1);
                else this.listInBasket[index].count! -= 1;
            }
            localStorage.setItem('basket', JSON.stringify(this.listInBasket));
        },

        removeById(id: number): void {
            this.listInBasket = JSON.parse(localStorage.getItem('basket') ?? '[]');
            const index = this.getIndexProductInBasketById(id);
            if (index != -1) {
                this.listInBasket.splice(index, 1);
                localStorage.setItem('basket', JSON.stringify(this.listInBasket));
            }
        }
    }
});