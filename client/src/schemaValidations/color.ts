import { z } from 'zod'
export const ColorRes = z
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

export type ColorResType = z.infer<typeof ColorRes>
