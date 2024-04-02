import {BASE_API_URL} from '@helpers/constants';
import {getAuthorizationToken} from './auth'
import axios from "axios";

axios.defaults.baseURL = BASE_API_URL;
axios.defaults.withCredentials = true;

export async function productById(id: string | number): Promise<any> {
    try {
        const response = await axios.get('/products/' + id);
        return response.data.data;
    } catch {
        return false;
    }
}

export async function pageOfProducts(num: number): Promise<any> {
    try {
        const response = await axios.get('/products/page/' + num);
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
        const response = await axios.get('/orders/page/' + num, {
            headers: {
                Authorization: getAuthorizationToken()
            }
        });
        return await response.data.data;
    } catch {
        return false;
    }
}
