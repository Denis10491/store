import axios from "axios";
import type {IMinifiedProduct} from "@user/modules/product/interfaces/IMinifiedProduct";
import {BASE_API_URL} from "@helpers/constants";

export async function useGetProducts(): Promise<Array<IMinifiedProduct>> {
    return (await axios.get(BASE_API_URL + '/products')).data
}
