export interface IProduct {
    id: number,
    img_path: string,
    name: string,
    description: string,
    composition: string,
    nutritional: {
        fats: number,
        proteins: number,
        carbohydrates: number
    },
    price: number,
    count?: number
}
