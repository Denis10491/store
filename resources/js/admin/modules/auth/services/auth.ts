import {useLogout} from "@admin/modules/auth/api/useLogout";

export class Auth {
    static token: string = ""

    static async logout(): Promise<any> {
        return await useLogout()
    }
}
