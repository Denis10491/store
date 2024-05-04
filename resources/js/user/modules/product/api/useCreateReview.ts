import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import {getAuthHeaders} from "@helpers/functions";
import {Auth} from "@user/modules/auth/services/auth";
import type {IReview} from "@user/modules/product/interfaces/IReview";
import type {ICreateReview} from "@user/modules/product/interfaces/ICreateReview";

export async function useCreateReview(productId: number, data: ICreateReview): Promise<IReview> {
    return (await (axios.post(BASE_API_URL + '/products/' + productId + '/reviews', data, getAuthHeaders(Auth.token)))).data
}
