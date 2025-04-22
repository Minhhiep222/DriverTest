import { z } from 'zod';

export const capabilities = z.object({
    data: z.object({
        id: z.string(),
        quantity: z.number(),
        status: z.string(),
    }),
    message: z.string(),
}).strict()

export type CapabilitiesType = z.TypeOf<typeof capabilities>

export const CapabilitiesCreateRes = z.object({
    quantity: z.preprocess(
        (val) => {
            if (val === '') return undefined
            return val
        }, z.number({
            required_error: "Vui lòng nhập số lượng người tham gia trong 1 giờ",
        }).min(0, "Số lượng phải lớn hơn 0").max(100, "Số lượng không được vượt quá 100")),
})
export type CapabilitiesCreateResType = z.infer<typeof CapabilitiesCreateRes>

export const CapabilitiesUpdateRes = z.object({
    id: z.string(),
    quantity: z.number(),
    status: z.string()
})
export type CapabilitiesUpdateResType = z.infer<typeof CapabilitiesUpdateRes>