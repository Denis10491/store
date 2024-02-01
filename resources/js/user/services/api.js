import axios from "axios";

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.defaults.withCredentials = true;

export async function login(email, password) {
    try {
        const response = await axios.post('/login', {
            email: email, password: password
        });
        const token = await response.data.token
        sessionStorage.setItem('token', await token);      
        return true;
    } catch {
        return false;
    }
}

export async function signup(name, email, password) {
    try {
        const response = await axios.post('/register', {
            name: name, email: email, password: password
        });
        return (!response) ? false : true;
    } catch {
        return false;
    }
}

export async function userInfo() {
    try {
        const response = await axios.get('/user/show', {
            headers: {
                Authorization: 'Bearer ' + sessionStorage.getItem('token')
            }
        });
        return response;
    } catch {
        return false;
    }
}

export async function logout() {
    try {
        await axios.get('/logout', {
            headers: {
                Authorization: 'Bearer ' + sessionStorage.getItem('token')
            }
        })
        sessionStorage.removeItem('token');
        window.location.href = '/';
        return true;
    } catch {
        return false;
    }
}

export async function productById(id) {
    try {
        const response = await axios.get('/products/show/'+id);
        return response.data.data;
    } catch {
        return false;
    }
}

export async function pageOfProducts(num) {
    try {
        const response = await axios.get('/products/index/'+num);
        return await response.data.data;
    } catch {
        return false;
    }
}

export async function createOrder(products, address) {
    try {
        const response = await axios.post('/orders/store', {
            products: JSON.stringify(products), address: address
        }, {
            headers: {
                Authorization: 'Bearer ' + sessionStorage.getItem('token')
            }
        });
        localStorage.removeItem('basket');
        return response.data;
    } catch {
        return false;
    }
}

export async function pageOfOrders(num) {
    try {
        const response = await axios.get('/orders/show/'+num, {
            headers: {
                Authorization: 'Bearer ' + sessionStorage.getItem('token')
            }
        });
        return await response.data.data;
    } catch {
        return false;
    }
}