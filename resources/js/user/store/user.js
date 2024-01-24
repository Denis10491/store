import { defineStore } from "pinia";

export const useUserStore = defineStore('user', {
    state: () => ({
        isAuth: false,
        isAdmin: false,
        id: null,
        name: "",
        email: "",
        token: 'Bearer ' + sessionStorage.getItem('token') ?? ""
    }),

    actions: {
        getUser() {
            return axios.get('/user/show', {
                headers: {
                    Authorization: this.token
                }
            })
            .then(response => {
                const data = response.data.data;
                this.isAuth = true;
                this.isAdmin = data.isAdmin;
                this.id = data.id;
                this.name = data.name;
                this.email = data.email;
                return true;
            })
            .catch(() => false)
        },

        logout() {
            return axios.post('/logout', {
                headers: {
                    Authorization: this.token
                }
            })
            .then(() => {
                sessionStorage.removeItem('token');
                window.location.href = '/';
                return true;
            })
            .catch(() => false)
        },
    }
})