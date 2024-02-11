let AUTH_TOKEN: string = '';

export function setAuthorizationToken(newToken: string): void {
    AUTH_TOKEN = newToken
}

export function getAuthorizationToken(): string {
    return AUTH_TOKEN;
}