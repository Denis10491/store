export default async function auth(context) {
    (context.store.isAuth) ? context.next() : context.next({ path: "/login" })
}