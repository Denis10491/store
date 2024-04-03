import type {IOrder} from "@user/modules/order/interfaces/IOrder";
import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@user/modules/auth/services/auth";

export async function useGetOrders(): Promise<Array<IOrder>> {
    return (await axios.get(BASE_API_URL + '/orders', getAuthHeaders(Auth.token))).data
}
