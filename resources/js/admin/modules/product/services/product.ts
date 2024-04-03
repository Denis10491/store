import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import {useGetProducts} from "@admin/modules/product/api/useGetProducts";
import {useDeleteProduct} from "@admin/modules/product/api/useDeleteProduct";
import {findIndexById} from "@helpers/functions";

export class Product {
    static store: any = null

    static async getAll(): Promise<Array<IMinifiedProduct>> {
        const products: Array<IMinifiedProduct> = await useGetProducts()
        Product.store.list = products
        return products
    }

    static async delete(id: number): Promise<any> {
        const index: number = findIndexById(Product.store.getList, id)
        Product.store.list.splice(index, 1)
        return await useDeleteProduct(id)
    }
}
