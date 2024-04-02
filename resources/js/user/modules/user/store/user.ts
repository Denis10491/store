import {defineStore} from "pinia";
import type {IUser} from "@user/modules/user/interfaces/IUser";

export const useUserStore = defineStore('user', {
    state: () => ({
        isAuth: false,
        id: NaN,
        name: "",
        email: ""
    }),

    getters: {
        getIsAuth(): boolean {
            return this.isAuth;
        }
    },

    actions: {
        init(data: IUser): void {
            this.isAuth = true
            this.id = data.id
            this.name = data.name
            this.email = data.email
        }
    }
})
