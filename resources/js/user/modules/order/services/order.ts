import type {IOrder} from "@user/modules/order/interfaces/IOrder";
import {useCreateOrder} from "@user/modules/order/api/useCreateOrder";
import {useGetOrders} from "@user/modules/order/api/useGetOrders";

export class Order {
    static async getAll(): Promise<Array<IOrder>> {
        return await useGetOrders()
    }

    static async create(data: IOrder): Promise<IOrder> {
        return await useCreateOrder(data)
    }
}
