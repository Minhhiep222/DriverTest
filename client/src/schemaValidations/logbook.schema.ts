import { z } from 'zod'

// Response schema for LogBook
export const LogBookRes = z
  .object({
    data: z.array(
      z.object({
        id: z.number(),
        driver_test_id: z.number(),
        fullname: z.string(),
        phone: z.string(),
        address: z.string(),
        time_drive: z.string(),
        note: z.string(),
        status: z.string(),
        created_at: z.string(),
        updated_at: z.string(),
      }),
    ),
    message: z.string(),
    totalRecord: z.number(),
  })
  .strict()

export type LogBookResType = z.infer<typeof LogBookRes>

// Body schema for LogBook, with validation for each field
export const LogBookBodyRes = z
  .object({
    driver_test_id: z.number(),
    fullname: z
      .string({
        required_error: 'Tên không được để trống',
        invalid_type_error: 'Tên phải là chuỗi',
      })
      .min(1, 'Tên không được để trống')
      .max(50, 'Tên không dài quá 50 ký tự'),
    phone: z
      .string({
        required_error: 'Số điện thoại không được để trống',
        invalid_type_error: 'Số điện thoại không hợp lệ',
      })
      .min(10, 'Số điện thoại phải có ít nhất 10 ký tự')
      .max(20, 'Số điện thoại không dài quá 20 ký tự')
      .regex(
        /^(0[1-9]\d{8,9}|(\+84|0)[1-9]\d{8}|\+[1-9]\d{1,14})$/,
        'Số điện thoại không hợp lệ',
      ),
    time_drive: z
      .string({
        required_error: 'Vui lòng chọn thời gian lái dự kiến',
        invalid_type_error: 'Không hợp lệ',
      })
      .min(1, 'Vui lòng chọn thời gian lái dự kiến'),
    date_drive: z
      .string({
        required_error: 'Vui lòng chọn thời gian lái dự kiến',
        invalid_type_error: 'Không hợp lệ',
      })
      .min(1, 'Vui lòng chọn thời gian lái dự kiến'),
    description: z
      .string()
      .max(500, 'Vui lòng không nhập quá 500 ký tự')
      .optional(),
  })
  .strict()

// Create schema for LogBook, omitting the driver_test_id field for creation
export const LogBookCreateRes = LogBookBodyRes

export type LogBookCreateResType = z.TypeOf<typeof LogBookCreateRes>

export const LogBookUpdateRes = z.object({
  id: z.number(),
  status: z.string(),
})

export type LogBookUpdateType = z.TypeOf<typeof LogBookUpdateRes>

// Response schema for LogBook
export const TimeBookRes = z
  .object({
    data: z.array(
      z.object({
        date: z.string(),
      }),
    ),
    message: z.string(),
  })
  .strict()

export type TimeBookResType = z.infer<typeof TimeBookRes>
