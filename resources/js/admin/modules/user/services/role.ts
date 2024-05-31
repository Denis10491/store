import type { IRole } from "@admin/modules/user/interfaces/IRole";
import { useGetRoles } from "@admin/modules/user/api/useGetRoles";
import { useAddPermissionToRole } from "@admin/modules/user/api/useAddPermissionToRole";
import { useRemovePermissionFromRole } from "@admin/modules/user/api/useRemovePermissionFromRole";

export class Role {
    static store: any = null
    
    static async getAll(): Promise<Array<IRole>> {
        const roles = await useGetRoles();
        Role.store.list = roles
        return roles
    }

    static async addPermission(roleId: number, permissionId: number): Promise<IRole> {
        return await useAddPermissionToRole(roleId, permissionId)
    }

    static async removePermission(roleId: number, permissionId: number): Promise<IRole> {
        return await useRemovePermissionFromRole(roleId, permissionId)
    }
}