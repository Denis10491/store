export interface Product {
    id: number, 
    imgPath: string,
    name: string,
    description: string,
    composition: string,
    nutritional: {
        fats: number,
        proteins: number,
        carbohydrates: number
    },
    price: number
}

export interface UserData {
    name?: string,
    email: string,
    password: string
}

export interface Order {
    id: number,
    address: string,
    products: Array<{
        product_id: number,
        name: string,
        count: number,
        price: number
    }>
    created_at: string
}