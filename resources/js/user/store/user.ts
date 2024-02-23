import { defineStore } from "pinia";
import { user } from "@user/services/api";

export const useUserStore = defineStore('user', {
    state: () => ({
        isAuth: false,
        id: NaN,
        name: "",
        email: ""
    }),

    getters: {
        getIsAuthStatus(): boolean {
            return this.isAuth;
        }
    },

    actions: {
        async getUserInfo(): Promise<boolean> {
            try {
                const response = await user();
                const data = await response.data;
                this.isAuth = data.status;
                this.name = data.data.name;
                this.email = data.data.email;
                return true;
            } catch {
                return false;
            }
        }
    }
})