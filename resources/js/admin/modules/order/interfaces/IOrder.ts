import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";
import type { Status } from "@admin/modules/order/enums/Status";

export interface IOrder {
    address: string,
    id?: number,
    products?: Array<IMinifiedProduct>,
    created_at?: Date | string
    status: Status,
}
