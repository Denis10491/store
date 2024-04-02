import {User} from "@user/modules/user/services/user";
import {useUserStore} from "@user/modules/user/store/user";
import {Auth} from "@user/modules/auth/services/auth";

export async function bootstrap(): Promise<void> {
    /*
    |--------------------------------------------------------------------------
    | Set Bearer Token
    |--------------------------------------------------------------------------
    */
    Auth.token = 'Bearer ' + sessionStorage.getItem('token') ?? ''

    /*
    |--------------------------------------------------------------------------
    | Initializing Storages in Services
    |--------------------------------------------------------------------------
    */
    User.store = useUserStore()

    /*
    |--------------------------------------------------------------------------
    | Receiving the First Data
    |--------------------------------------------------------------------------
    */
    await User.show()
}
