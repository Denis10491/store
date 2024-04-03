export interface Order {
    id: number,
    address: string,
    products: [{
        product_id: number,
        name: string,
        count: number,
        price: number
    }]
    created_at: Date | string
}
