import type {IProduct} from "@user/modules/product/interfaces/IProduct";
import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";

export async function useGetProductById(id: number): Promise<IProduct> {
    return await (await axios.get(BASE_API_URL + '/products/' + id)).data
}
