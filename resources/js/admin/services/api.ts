import { getAuthorizationToken } from "@user/services/auth";
import { BASE_API_URL } from '@helpers/constants';
import axios from "axios";

axios.defaults.baseURL = BASE_API_URL;
axios.defaults.withCredentials = true;

export async function pageOfProducts(num: number): Promise<any> {
    try {
        const response = await axios.get('/products/page/'+num);
        return await response.data.data;
    } catch {
        return false;
    }
}

export async function createProduct(form: { name: string | Blob; description: string | Blob; img: string | Blob; nutritional: { proteins: string | Blob; fats: string | Blob; carbohydrates: string | Blob; }; composition: string | Blob; price: string | Blob; }) {
    const formData = new FormData();

    formData.append('name', form.name);
    formData.append('description', form.description);
    formData.append('image', form.img);
    formData.append('proteins', form.nutritional.proteins);
    formData.append('fats', form.nutritional.fats);
    formData.append('carbohydrates', form.nutritional.carbohydrates);
    formData.append('composition', form.composition);
    formData.append('price', form.price);

    try {
        await axios.post('/products', formData, {
            headers: {
                Authorization: getAuthorizationToken(),
                'Content-Type': 'multipart/form-data'
            }
        });
        return true;
    } catch {
        return false;
    }
}

export async function updateProduct(form: { img: string | Blob; name: string | Blob; description: string | Blob; nutritional: { proteins: string | Blob; fats: string | Blob; carbohydrates: string | Blob; }; composition: string | Blob; price: string | Blob; id: string; }) {
    const formData = new FormData();
    if (form.img) formData.append('image', form.img);
    formData.append('name', form.name);
    formData.append('description', form.description);
    formData.append('proteins', form.nutritional.proteins);
    formData.append('fats', form.nutritional.fats);
    formData.append('carbohydrates', form.nutritional.carbohydrates);
    formData.append('composition', form.composition);
    formData.append('price', form.price);
    try {
        await axios.put('/products/' + form.id, formData, {
            headers: {
                Authorization: getAuthorizationToken(),
                'Content-Type': 'multipart/form-data'
            }
        });
        return true;
    } catch {
        return false;
    }
}

export async function deleteProduct(productId: string) {
    try {
        await axios.delete('/products/' + productId, {
            headers: {
                Authorization: getAuthorizationToken()
            }
        });
        return true;
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

export async function getCountOfOrders(year: string | number, month: string | number) {
    const response = await axios.get('/statistics/orders/monthlyamountbyday?year='+year+'&month='+month, {
        headers: {
            Authorization: getAuthorizationToken()
        }
    });
    return await response.data.data;
}

export async function getBestSellingProducts(year: string | number, month: string | number) {
    const response = await axios.get('/statistics/products/monthlybestselling?year='+year+'&month='+month, {
        headers: {
            Authorization: getAuthorizationToken()
        }
    });
    return await response.data.data;
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