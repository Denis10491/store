import { IPermission } from "@admin/modules/user/interfaces/IPermission"

export interface IRole {
    id: number,
    name: string,
    permissions: Array<IPermission>
}