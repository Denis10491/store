import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@admin/modules/auth/services/auth";

export async function useProductStatistics(year: number, month: number): Promise<any> {
    return (await axios.get(BASE_API_URL + `/products/statistics/monthlybestselling?year=${year}&month=${month}`,
        getAuthHeaders(Auth.token))).data
}
