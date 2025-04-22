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
        updated_at: z.string(),
      }),
    ),
  })
  .strict()

export type SettingResType = z.infer<typeof SettingRes>

export const SettingCreateRes = z.array(z.object({
  date: z.string({
    // required_error: "Vui lòng chọn ngày"
  }).optional().nullable(),
  start: z.string({
    required_error: "Vui lòng nhập số giờ"
  }),
  end: z.string({
    required_error: "Vui lòng nhập số giờ"
  }),
  status: z.string(),
}))

export type SettingCreateResType = z.infer<typeof SettingCreateRes>


export const SettingUpdateRes = z.object({
  date: z.string(),
  start: z.string(),
  end: z.string(),
  status: z.string(),
})

export type SettingUpdateResType = z.infer<typeof SettingUpdateRes>
