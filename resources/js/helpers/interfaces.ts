export interface Product {
    id: number,
    imgPath: string,
    name: string,
    description: string,
    composition: string,
    nutritional: Nutritional,
    price: number,
    count?: number
}

export interface ArrayProduct extends Array<any> {
    [page: number]: Array<Product>
}

export interface Nutritional {
    fats: number,
    proteins: number,
    carbohydrates: number
}

export interface ArrayOrder extends Array<any> {
    [page: number]: Array<Order>
}

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
