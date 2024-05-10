import {useLogout} from "@admin/modules/auth/api/useLogout";

export class Auth {
    static token: string = ""

    static async logout(): Promise<any> {
        try {
            return await useLogout()
        } catch {
            sessionStorage.removeItem('token')
            Auth.token = ''
        }
    }
}
