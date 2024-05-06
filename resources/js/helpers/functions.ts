export function getPriceOfProducts(products: Array<any>): number {
    return products.reduce((sum: number, product: { price: number; }) => sum + product.price, 0);
}

export function findIndexById(list: Array<{ id: number }>, id: number): number {
    return list.findIndex((item: { id: string | number }): boolean => item.id === id)
}


export function findItemById(list: Array<{ id: number }>, id: number): any {
    return list.find((item: { id: string | number }): boolean => item.id === id)
}

export function getImg(path: string): string {
    return (path.slice(0, 4) == 'http') ? path : '../' + path;
}

export function toDateViewFormat(date: string | Date): string {
    return date.toString().slice(0, 10).split('-').join('.')
}

export function getHeaders(): object {
    return {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }
}

export function getAuthHeadersFormData(token: string): object {
    return {
        headers: {
            'Authorization': token,
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
        }
    }
}

export function getAuthHeaders(token: string): object {
    return {
        headers: {
            'Authorization': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }
}

export function getMonth(date: Date): number {
    let dateString = date.toDateString()
    switch (dateString.substring(4).substring(3, dateString.length)) {
        case 'Jan':
            return 0
        case 'Feb':
            return 1
        case 'Mar':
            return 2
        case 'Apr':
            return 3
        case 'May':
            return 4
        case 'Jun':
            return 5
        case 'Jul':
            return 6
        case 'Aug':
            return 7
        case 'Sen':
            return 8
        case 'Oct':
            return 9
        case 'Nov':
            return 10
        case 'Dec':
            return 11
        default:
            return 0
    }
}
