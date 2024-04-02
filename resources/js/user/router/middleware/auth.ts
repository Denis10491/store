import {User} from "@user/modules/user/services/user";

export default function auth(context): void {
    (User.store.getIsAuth) ? context.next() : context.next({path: "/"});
}
