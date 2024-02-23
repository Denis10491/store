export default function guest(context) {
    (context.status === false) ? context.next() : context.next({ path: "/" });
}