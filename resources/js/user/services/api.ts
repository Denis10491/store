import { getAuthorizationToken } from './auth'
import axios from "axios";

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.defaults.withCredentials = true;

export async function login(email: string, password: string): Promise<boolean> {
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

export async function signup(name: string, email: string, password: string): Promise<boolean> {
    try {
        const response = await axios.post('/register', {
            name: name, email: email, password: password
        });
        return (!response) ? false : true;
    } catch {
        return false;
    }
}

export async function user(): Promise<any> {
    try {
        const response = await axios.get('/user', {
            headers: {
                Authorization: getAuthorizationToken()
            }
        });
        return response;
    } catch {
        return false;
    }
}

export async function logout(): Promise<boolean> {
    try {
        await axios.get('/logout', {
            headers: {
                Authorization: getAuthorizationToken()
            }
        })
        sessionStorage.removeItem('token');
        window.location.href = '/';
        return true;
    } catch {
        return false;
    }
}

export async function productById(id: string | number): Promise<any> {
    try {
        const response = await axios.get('/products/'+id);
        return response.data.data;
    } catch {
        return false;
    }
}

export async function pageOfProducts(num: number): Promise<any> {
    try {
        const response = await axios.get('/products/page/'+num);
        return await response.data.data;
    } catch {
        return false;
    }
}

export async function createOrder(products: object, address: string): Promise<any> {
    try {
        const response = await axios.post('/orders', {
            products: JSON.stringify(products), address: address
        }, {
            headers: {
                Authorization: getAuthorizationToken()
            }
        });
        localStorage.removeItem('basket');
        return response.data;
    } catch {
        return false;
    }
}

export async function pageOfOrders(num: number): Promise<any> {
    try {
        const response = await axios.get('/orders/page/'+num, {
            headers: {
                Authorization: getAuthorizationToken()
            }
        });
        return await response.data.data;
    } catch {
        return false;
    }
}