import { defineStore } from "pinia";
import { userInfo } from "../services/api";

export const useUserStore = defineStore('user', {
    state: () => ({
        isAuth: false,
        isAdmin: false,
        id: null,
        name: "",
        email: ""
    }),

    getters: {
        isAuthStatus() {
            return this.isAuth ?? false;
        }
    },

    actions: {
        getUserInfo() {
            return userInfo().then(response => {
                const data = response.data;
                this.isAuth = data.status;
                this.isAdmin = data.data.isAdmin;
                this.name = data.data.name;
                this.email = data.data.email;
                return true;
            })
            .catch(() => false);
        }
    }
})