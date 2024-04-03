import type {IUser} from "@user/modules/user/interfaces/IUser";
import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@user/modules/auth/services/auth";

export async function useGetUser(): Promise<IUser> {
    const {data} = await axios.get(BASE_API_URL + '/user', getAuthHeaders(Auth.token))
    return data
}
