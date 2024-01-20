export default async function guest(context) {
    (!context.store.isAuth) ? context.next() : context.next({ path: "/" })
}