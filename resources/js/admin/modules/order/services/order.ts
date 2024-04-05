import type {IOrder} from "@admin/modules/order/interfaces/IOrder";
import {useGetOrders} from "@admin/modules/order/api/useGetOrders";
import {useOrderStatistics} from "@admin/modules/order/api/useOrderStatistics";

export class Order {
    static store: any = null

    static async getAll(): Promise<Array<IOrder>> {
        const orders: Array<IOrder> = await useGetOrders()
        Order.store.list = orders
        return orders
    }

    static async statistics(year: number, month: number) {
        return await useOrderStatistics(year, month)
    }
}
