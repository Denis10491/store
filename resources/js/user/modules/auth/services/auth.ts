import {useLogin} from "@user/modules/auth/api/useLogin";
import type {IToken} from "@user/modules/auth/interfaces/IToken";
import {useSignup} from "@user/modules/auth/api/useSignup";
import type {IUserData} from "@user/modules/auth/interfaces/IUserData";
import {useLogout} from "@user/modules/auth/api/useLogout";

export class Auth {
    static token: string = ""

    static async signup(name: string, email: string, password: string): Promise<IUserData> {
        return await useSignup(name, email, password)
    }

    static async login(email: string, password: string): Promise<IToken> {
        const data: IToken = await useLogin(email, password)
        sessionStorage.setItem('token', data.token)
        Auth.token = data.token
        return data
    }

    static async logout(): Promise<any> {
        return await useLogout()
    }
}
