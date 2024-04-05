import {BASE_API_URL} from "@helpers/constants";
import axios from "axios";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@admin/modules/auth/services/auth";

export async function useOrderStatistics(year: number, month: number) {
    return (await axios.get(BASE_API_URL + `/orders/statistics/monthlyamountbyday?year=${year}&month=${month}`, getAuthHeaders(Auth.token))).data
}
