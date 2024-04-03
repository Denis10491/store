import {User} from "@user/modules/user/services/user";
import {useUserStore} from "@user/modules/user/store/user";
import {Auth} from "@user/modules/auth/services/auth";
import {Product} from "@user/modules/product/services/product";
import {Basket} from "@user/modules/product/services/basket";
import {useProductsStore} from "@user/modules/product/store/product";
import {useBasketStore} from "@user/modules/product/store/basket";

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
    User.store = useUserStore()
    Product.store = useProductsStore()
    Basket.store = useBasketStore()

    /*
    |--------------------------------------------------------------------------
    | Receiving the First Data
    |--------------------------------------------------------------------------
    */
    User.show()
    Product.getAll()
    Basket.load()
}
