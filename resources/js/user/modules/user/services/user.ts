import type {IUser} from "@user/modules/user/interfaces/IUser";
import {useGetUser} from "@user/modules/user/api/useGetUser";

export class User {
    static store: any = null

    static async show(): Promise<IUser> {
        const user: IUser = await useGetUser()
        User.store?.init(user)
        return user
    }
}
