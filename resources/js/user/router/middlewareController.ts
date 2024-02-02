export default function middlewareController(context, middleware, index = 1) {
    const nextMiddleware = middleware[index];
    if (!nextMiddleware) return context.next;
    return () => {
        nextMiddleware({
            ...context,
            next: middlewareController(context, middleware, index + 1)
        })
    }
}