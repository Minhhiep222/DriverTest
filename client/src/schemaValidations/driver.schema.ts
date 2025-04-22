import { z } from 'zod'
import { CapabilitiesCreateRes } from './capabilities.schema'

export const DriverRes = z
  .object({
    data: z.array(
      z.object({
        id: z.number(),
        name: z.string(),
        color: z.string(),
        showroom: z.string(),
        vehicle_type: z.string(),
        location: z.string(),
        start_time: z.string(),
        end_time: z.string(),
        status: z.string(),
        contact: z.string(),
        description: z.string(),
        created_at: z.string(),
        updated_at: z.string(),
        images: z.array(
          z.object({
            filename: z.string(),
            path: z.string(),
          }),
        ),
      }),
    ),
    message: z.string(),
    totalRecord: z.number(),
  })
  .strict()

export type DriverResType = z.infer<typeof DriverRes>

export const DriverReadRes = z
  .object({
    data: z.object({
      id: z.number(),
      name: z.string(),
      color: z.string(),
      showroom: z.string(),
      vehicle_type: z.string(),
      location: z.string(),
      start_time: z.string(),
      end_time: z.string(),
      status: z.string(),
      contact: z.string(),
      description: z.string(),
      created_at: z.string(),
      updated_at: z.string(),
      confirm: z.enum(['yes', 'no']),
      img: z.array(
        z.object({
          filename: z.string(),
          path: z.string(),
        }),
      ),
    }),
    message: z.string(),
  })
  .strict()

export type DriverReadResType = z.infer<typeof DriverReadRes>

export const DriverResponse = z.object({
  driver_test_id: z.number(),
  date_drive: z.string(),
  time_drive: z.string(),
  note: z.string().optional(),
  created_at: z.string(),
  updated_at: z.string(),
  books: z.array(z.any()),
})

export const DriverCreateRes = z
  .object({
    id: z.number().optional(),
    name: z
      .string({
        required_error: 'Tên không được để trống',
        invalid_type_error: 'Tên phải là chuỗi',
      })
      .min(1, 'Tên không được để trống')
      .min(10, 'Tên phải chứa ít nhất 10 ký tự')
      .max(50, 'Tên không dài quá 50 ký tự'),

    color: z
      .string({
        required_error: 'Màu sắc không được để trống',
        invalid_type_error: 'Màu sắc phải là chuỗi',
      })
      .min(1, 'Màu sắc không được để trống'),

    showroom: z
      .string({
        required_error: 'Hãng không được để trống',
        invalid_type_error: 'Hãng phải là chuỗi',
      })
      .min(1, 'Hãng không được để trống'),

    location: z.preprocess(
      (val) => {
        if (val === '') return undefined
        return val
      },
      z
        .string({
          required_error: 'Địa chỉ không được để trống',
          invalid_type_error: 'Địa chỉ phải là chuỗi',
        })
        .min(1, 'Địa điểm không được để trống')
        .max(50, 'Địa điểm không dài quá 50 ký tự'),
    ),
    vehicle_type: z
      .string({})
      .max(50, 'Loại xe không dài quá 50 ký tự')
      .optional().nullable(),

    start_time: z
      .string({

      }).optional().nullable()
    ,
    end_time: z
      .string({
        required_error: 'Vui lòng chọn ngày',
        invalid_type_error: 'Thời gian kết thúc phải là chuỗi',
      })
      .min(1, 'Vui lòng chọn ngày')
      .refine((val) => {
        const endDate = new Date(val)
        return endDate
      }),

    status: z.string({}).optional().nullable(),

    contact: z
      .string({
        required_error: "Vui lòng nhập liên hệ"
      })
      .regex(
        /^(0[1-9]\d{8,9}|(\+84|0)[1-9]\d{8}|\+[1-9]\d{8}|\+[1-9]\d{1,14})$/,
        'Liên hệ không hợp lệ',
      ),

    description: z
      .string({
        required_error: "Mô tả chi tiết không được để trống"
      })
      .max(500, 'Mô tả không dài quá 500 ký tự'),

    images: z.array(z.object({
    }), {
      required_error: 'Hình ảnh không được để trống',
    }).max(5, 'Tối đa 5 hình ảnh'), // img có thể là mảng rỗng hoặc không có giá trị

    confirm: z.enum(['yes', 'no'], {}).nullable().optional(), // Xác nhận có thể là yes hoặc no
  })
  .strict().merge(CapabilitiesCreateRes)

export type DriverCreateResType = z.infer<typeof DriverCreateRes>

export const DriverUpdateRes = DriverCreateRes.extend({
  user_id: z.number(),
  created_at: z.string(),
  updated_at: z.string(),
})
export type DriverUpdateResType = z.infer<typeof DriverUpdateRes>

export const DriveComfirmRes = z.object({
  id: z.number(),
  name: z.string(),
  confirm: z.enum(['yes', 'no']),
})

export type DriveComfirmResType = z.infer<typeof DriveComfirmRes>
