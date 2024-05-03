import {useCreateReview} from "@user/modules/product/api/useCreateReview";
import type {ICreateReview} from "@user/modules/product/interfaces/ICreateReview";
import type {IReview} from "@user/modules/product/interfaces/IReview";

export class Review {
    static async create(productId: number, data: ICreateReview): Promise<IReview> {
        return await useCreateReview(productId, data)
    }
}
