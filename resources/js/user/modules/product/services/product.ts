import {useGetProducts} from "@user/modules/product/api/useGetProducts";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";
import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import {useGetProductById} from "@user/modules/product/api/useGetProductById";

export class Product {
    static store: any = null

    static async getAll(): Promise<Array<IMinifiedProduct>> {
        const products: Array<IMinifiedProduct> = await useGetProducts()
        Product.store.list = products
        return products
    }

    static async getById(id: number): Promise<IProduct> {
        return await useGetProductById(id)
    }
}
