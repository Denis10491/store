export default async function auth(context) {
    (!context.isAuthStatus) ? context.next() : context.next({ path: "/" })
}