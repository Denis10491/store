import {defineStore} from "pinia";
import type {IRole} from "@admin/modules/user/interfaces/IRole";

export const useRoleStore = defineStore('role', {
    state: () => ({
        list: [] as Array<IRole>,
    }),

    getters: {
        getList(): Array<IRole> {
            return this.list
        }
    }
})
