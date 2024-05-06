import type {IProduct} from "@admin/modules/product/interfaces/IProduct";
import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeadersFormData} from "@helpers/functions";
import {Auth} from "@admin/modules/auth/services/auth";

/**
 * Request Method: PATCH
 * 
 * @param productId: number
 * @param formData: FormData
 * @returns Promise<IProduct>
 */
export async function useUpdateProduct(productId: number, formData: FormData): Promise<IProduct> {
    return (await axios.post(BASE_API_URL + '/products/' + productId, formData, getAuthHeadersFormData(Auth.token))).data
}
