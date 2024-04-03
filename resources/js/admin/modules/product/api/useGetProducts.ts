import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import type {IMinifiedProduct} from "@admin/modules/product/interfaces/IMinifiedProduct";

export async function useGetProducts(): Promise<Array<IMinifiedProduct>> {
    return (await axios.get(BASE_API_URL + '/products')).data
}
