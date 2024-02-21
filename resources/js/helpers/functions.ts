export function getPriceOfProducts (products: any[]): number {
    return products.reduce((sum: number, product: { price: number; }) => sum + product.price, 0);
}

export function getMonth(date: Date) {
    let dateString = date.toDateString()
    switch(dateString.substring(4).substring(3, dateString.length)) {
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