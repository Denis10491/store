import {Auth} from "@admin/modules/auth/services/auth";
import {Product} from "@admin/modules/product/services/product";
import {useProductStore} from "@admin/modules/product/store/product";

export function bootstrap(): void {
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
    Product.store = useProductStore()
}
