import { z } from 'zod'
export const CarRes = z
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

export type CarResType = z.infer<typeof CarRes>
