import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeadersFormData} from "@helpers/functions";
import type {IProduct} from "@admin/modules/product/interfaces/IProduct";
import {Auth} from "@admin/modules/auth/services/auth";

export async function useCreateProduct(product: FormData): Promise<IProduct> {
    return (await axios.post(BASE_API_URL + '/products', product, getAuthHeadersFormData(Auth.token))).data
}
