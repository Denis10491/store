import {defineStore} from "pinia";
import type {IPermission} from "@admin/modules/user/interfaces/IPermission";

export const usePermissionStore = defineStore('permission', {
    state: () => ({
        list: [] as Array<IPermission>,
    }),

    getters: {
        getList(): Array<IPermission> {
            return this.list
        }
    }
})
