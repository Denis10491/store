import type { IPermission } from "@admin/modules/user/interfaces/IPermission";
import { useGetPermissions } from "../api/useGetPermissions";

export class Permission {
    static store: any = null

    static async getAll(): Promise<Array<IPermission>> {
        const permissions = await useGetPermissions();
        Permission.store.list = permissions
        return permissions
    }
}