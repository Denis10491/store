export default async function admin(context) {
    (context.store.isAdmin) ? context.next() : context.next({ path: "/" })
}