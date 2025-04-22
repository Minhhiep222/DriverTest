import { z } from 'zod'
export const CarBrandsRes = z
  .object({
    data: z.array(
      z.object({
        id: z.number(),
        name: z.string(),
        user_id: z.number(),
      }),
    ),
    message: z.string(),
    totalRecord: z.number(),
  })
  .strict()

export type CarBrandsResType = z.infer<typeof CarBrandsRes>
