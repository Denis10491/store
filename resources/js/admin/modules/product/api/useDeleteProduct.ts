import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@admin/modules/auth/services/auth";

export async function useDeleteProduct(id: number): Promise<any> {
    return await axios.delete(BASE_API_URL + '/products/' + id, getAuthHeaders(Auth.token))
}
