import { Auth } from "@admin/modules/auth/services/auth";
import type { IRole } from "@admin/modules/user/interfaces/IRole";
import { BASE_API_URL } from "@helpers/constants";
import { getAuthHeaders } from "@helpers/functions";
import axios from "axios";

export async function useRemovePermissionFromRole(roleId: number, permissionId: number): Promise<IRole> {
    return (await (axios.delete(BASE_API_URL + '/roles/' + roleId + '/permissions/' + permissionId, getAuthHeaders(Auth.token)))).data
}