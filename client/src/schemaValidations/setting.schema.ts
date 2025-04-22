import { z } from 'zod'

export const SettingRes = z
  .object({
    data: z.array(
      z.object({
        id: z.number(),
        date: z.string(),
        start: z.string(),
        end: z.string(),
        status: z.string(),
        created_at: z.string(),
        updated_at: z.string()
      })
    )
  })
  .strict()

export type SettingResType = z.infer<typeof SettingRes>

export const SettingUpdateRes = z.array(z.object({
  id: z.number(),
  date: z.string(),
  start: z.string(),
  end: z.string(),
  status: z.string(),
})
)
export type SettingUpdateResType = z.infer<typeof SettingUpdateRes>
