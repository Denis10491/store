import {useLogin} from "@user/modules/auth/api/useLogin";
import type {IToken} from "@user/modules/auth/interfaces/IToken";

export class Auth {
    static async login(email: string, password: string): Promise<IToken> {
        return await useLogin(email, password)
    }
}
