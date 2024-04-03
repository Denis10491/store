import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import {useGetOrders} from "@admin/modules/order/api/useGetOrders";

export class Order {
    static store: any = null

    static async getAll(): Promise<Array<IOrder>> {
        const orders: Array<IOrder> = await useGetOrders()
        Order.store.list = orders
        return orders
    }
}
