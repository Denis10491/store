import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {

    actions: {
        login(email, password) {
            return axios.post('/login', {
                email: email, password: password
            })
            .then(response => {
                sessionStorage.setItem('token', response.data.token);
                return true;
            })
            .catch(() => false)
        },
    
        signup(name, email, password) {
            return axios.post('/register', {
                name: name, email: email, password: password
            })
            .then(() => true)
            .catch(() => false)
        }
    }
})