import { defineStore } from "pinia";
import { user } from "../services/api";

export const useUserStore = defineStore('user', {
    state: () => ({
        isAuth: false,
        id: NaN,
        name: "",
        email: ""
    }),

    getters: {
        isAuthStatus() {
            return this.isAuth ?? false;
        }
    },

    actions: {
        async getUserInfo() {
            try {
                const response = await user();
                const data = response.data;
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