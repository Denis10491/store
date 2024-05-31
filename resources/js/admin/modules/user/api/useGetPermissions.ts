import { Auth } from "@admin/modules/auth/services/auth";
import type { IPermission } from "@admin/modules/user/interfaces/IPermission";
import { BASE_API_URL } from "@helpers/constants";
import { getAuthHeaders } from "@helpers/functions";
import axios from "axios";

export async function useGetPermissions(): Promise<Array<IPermission>> {
    return (await axios.get(BASE_API_URL + '/permissions', getAuthHeaders(Auth.token))).data
}