import {BASE_API_URL} from "@helpers/constants";
import axios from "axios";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@user/modules/auth/services/auth";
import type {IOrder} from "@user/modules/order/interfaces/IOrder";

export async function useCreateOrder(data: IOrder): Promise<IOrder> {
    return (await axios.post(BASE_API_URL + '/orders', data, getAuthHeaders(Auth.token))).data
}
