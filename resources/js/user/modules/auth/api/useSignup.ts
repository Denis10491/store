import axios from "axios";
import {BASE_API_URL} from "@helpers/constants";
import type {IUserData} from "@user/modules/auth/interfaces/IUserData";

export async function useSignup(name: string, email: string, password: string): Promise<IUserData> {
    const {data} = await axios.post(BASE_API_URL + '/auth/register', {
        name: name,
        email: email,
        password: password
    });
    return data
}
