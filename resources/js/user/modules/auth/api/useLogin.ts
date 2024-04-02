import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import type {IToken} from "@user/modules/auth/interfaces/IToken";

export async function useLogin(email: string, password: string): Promise<IToken> {
    const {data} = await axios.post(BASE_API_URL + '/auth/login', {
        email: email,
        password: password
    })
    return data
}
