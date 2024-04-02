import {BASE_API_URL} from "@helpers/constants";
import axios from "axios";

export async function useLogout(): Promise<any> {
    return await axios.get(BASE_API_URL + '/auth/logout')
}
