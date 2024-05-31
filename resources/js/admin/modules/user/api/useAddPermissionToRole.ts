import { Auth } from "@admin/modules/auth/services/auth";
import type { IRole } from "@admin/modules/user/interfaces/IRole";
import { BASE_API_URL } from "@helpers/constants";
import { getAuthHeaders } from "@helpers/functions";
import axios from "axios";

export async function useAddPermissionToRole(roleId: number, permissionId: number): Promise<IRole> {
    return (await (axios.post(BASE_API_URL + '/roles/' + roleId + '/permissions',
        JSON.stringify({
            permission_id: permissionId
        }),
        getAuthHeaders(Auth.token)
    ))).data
}