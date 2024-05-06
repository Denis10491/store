import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import {useGetProducts} from "@admin/modules/product/api/useGetProducts";
import {useDeleteProduct} from "@admin/modules/product/api/useDeleteProduct";
import {findIndexById} from "@helpers/functions";
import {useProductStatistics} from "@admin/modules/product/api/useProductStatistics";
import type {IProduct} from "@admin/modules/product/interfaces/IProduct";
import {useCreateProduct} from "@admin/modules/product/api/useCreateProduct";
import {useUpdateProduct} from "@admin/modules/product/api/useUpdateProduct";

export class Product {
    static store: any = null

    static async getAll(): Promise<Array<IMinifiedProduct>> {
        const products: Array<IMinifiedProduct> = await useGetProducts()
        Product.store.list = products
        return products
    }

    static async create(product: FormData): Promise<IProduct> {
        const createdProduct: IProduct = await useCreateProduct(product)
        Product.store.list.push(createdProduct)
        return createdProduct
    }

    static async update(formData: FormData): Promise<IProduct> {
        const updatedProduct: IProduct = await useUpdateProduct(this.store.selectedId, formData)

        const index: number = findIndexById(Product.store.list, this.store.selectedId)
        this.store.list[index] = updatedProduct

        return updatedProduct
    }

    static async delete(id: number): Promise<any> {
        const index: number = findIndexById(Product.store.getList, id)
        Product.store.list.splice(index, 1)
        return await useDeleteProduct(id)
    }

    static async statistics(year: number, month: number): Promise<any> {
        return await useProductStatistics(year, month)
    }
}
