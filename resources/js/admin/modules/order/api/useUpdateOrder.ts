import { Auth } from "@admin/modules/auth/services/auth";
import { BASE_API_URL } from "@helpers/constants";
import { getAuthHeaders } from "@helpers/functions";
import axios from "axios";
import type { IOrder } from "@admin/modules/order/interfaces/IOrder";

export async function useUpdateOrder(orderId: number, data: {}): Promise<IOrder> {
    return (await axios.patch(BASE_API_URL + '/orders/' + orderId, data, getAuthHeaders(Auth.token))).data
}