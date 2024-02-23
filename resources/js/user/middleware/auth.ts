export default function auth(context) {
    (context.status === true) ? context.next() : context.next({ path: "/" });
}