import type {IOrder} from "@user/modules/order/interfaces/IOrder";
import {useCreateOrder} from "@user/modules/order/api/useCreateOrder";

export class Order {
    static async create(data: IOrder): Promise<IOrder> {
        return await useCreateOrder(data)
    }
}
