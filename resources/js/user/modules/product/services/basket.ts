import {findIndexById, findItemById} from "@helpers/functions";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";
import {Product} from "@user/modules/product/services/product";

export class Basket {
    static store: any = null

    static plus(id: number): void {
        const index: number = findIndexById(Basket.store.getList, id)
        const product: IMinifiedProduct = findItemById(Product.store.getList, id)

        if (index === -1) {
            product.count = 1
            Basket.store.list.push(product)
        } else {
            Basket.store.list[index].count! += 1;
        }

        Basket.save()
    }

    static minus(id: number): void {
        const index: number = findIndexById(Basket.store.getList, id)

        Basket.store.list[index].count -= 1
        if (Basket.store.getList[index].count! === 0) {
            Basket.store.list.splice(index, 1);
        }

        Basket.save()
    }

    static remove(id: number): void {
        const index: number = findIndexById(Basket.store.getList, id)

        if (index !== -1) {
            Basket.store.list.splice(index, 1)
        }

        Basket.save()
    }

    static save(): void {
        localStorage.setItem('basket', JSON.stringify(Basket.store.list))
    }

    static load(): void {
        Basket.store.list = JSON.parse(localStorage.getItem('basket') ?? '[]')
    }
}
