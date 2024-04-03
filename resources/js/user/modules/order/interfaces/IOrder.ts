import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";

export interface IOrder {
    address: string,
    id?: number,
    products?: Array<IMinifiedProduct>,
    created_at?: Date | string
}
