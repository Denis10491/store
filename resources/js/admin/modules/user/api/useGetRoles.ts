import { Auth } from "@admin/modules/auth/services/auth";
import { BASE_API_URL } from "@helpers/constants";
import { getAuthHeaders } from "@helpers/functions";
import axios from "axios";
import type { IRole } from "@admin/modules/user/interfaces/IRole";

export async function useGetRoles(): Promise<Array<IRole>> {
    return (await axios.get(BASE_API_URL + '/roles', getAuthHeaders(Auth.token))).data
}