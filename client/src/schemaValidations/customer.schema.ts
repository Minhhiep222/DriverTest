import { z } from 'zod'

export const CustomerRes = z
  .object({
    customer: z.array(
      z.object({
        id: z.number(),
        user_id: z.number(),
        fullname: z.string(),
        phone: z.string(),
        address: z.string(),
        area: z.string(),
        email: z.string(),
        img: z.string().optional(),
        hobbit: z.string(),
        income: z.number(),
        members: z.number(),
        age: z.number(),
        owned: z.string(),
        sex: z.string().optional(),
        status: z.string(),
        type: z.string(),
      }),
    ),
    message: z.string(),
    totalRecord: z.number(),
  })
  .strict()

export type CustomerResType = z.TypeOf<typeof CustomerRes>

export const CustomerBodyRes = z
  .object({
    id: z.number(),
    fullname: z
      .string({ required_error: 'Họ tên không được để trống' })
      .min(1, 'Họ tên không được để trống')
      .max(50, 'Họ và tên không dài quá 50 ký tự')
      .trim(),
    phone: z
      .string({
        required_error: 'Số điện thoại không được để trống',
      })
      .regex(
        /^(0[1-9]\d{8,9}|(\+84|0)[1-9]\d{8}|\+[1-9]\d{1,14})$/,
        'Số điện thoại không hợp lệ',
      )
      .trim(),
    address: z
      .string()
      .max(100, 'Địa chỉ không dài quá 100 ký tự')
      .trim()
      .nullable()
      .optional(),
    area: z
      .string({ required_error: 'Khu vực không được để trống' })
      .max(50, 'Khu vực không dài quá 50 ký tự')
      .trim()
      .nullable()
      .optional(),
    email: z.preprocess(
      (val) => {
        if (val === '') return undefined
        return val
      },
      z
        .string()
        .email('Định dạng email không hợp lệ')
        .max(50, 'Email không dài quá 50 ký tự')
        .trim()
        .optional()
        .nullable(),
    ),
    hobbit: z
      .string()
      .max(100, 'Sở thích không dài quá 100 ký tự')
      .trim()
      .nullable()
      .optional(),

    income: z.preprocess(
      (val) => {
        if (val === '') return undefined
        const num = Number(val)
        return isNaN(num) ? undefined : num
      },
      z
        .number({
          invalid_type_error: 'Số thu nhập không hợp lệ',
        })
        .int('Số thu nhập phải là số nguyên')
        .min(1, 'Số thu nhập phải lớn hơn 0')
        .max(1000000000, 'Số thu nhập không lớn hơn 1 tỷ')
        .nullable()
        .optional()
        .transform((val) => (val ? Number(val) : null)),
    ),

    members: z.preprocess(
      (val) => {
        if (val === '') return undefined
        const num = Number(val)
        return isNaN(num) ? undefined : num
      },
      z
        .number({
          invalid_type_error: 'Số thành viên không hợp lệ',
        })
        .int('Số thành viên phải là số nguyên')
        .min(1, 'Số thành viên phải lớn hơn 0')
        .max(100, 'Số thành viên không lớn hơn 100')
        .nullable()
        .optional()
        .transform((val) => (val ? Number(val) : null)),
    ),
    age: z.preprocess(
      (val) => {
        if (val === '') return undefined
        const num = Number(val)
        return isNaN(num) ? undefined : num
      },
      z
        .number({
          invalid_type_error: 'Tuổi không hợp lệ',
        })
        .int('Tuổi phải là số nguyên')
        .min(1, 'Tuổi phải lớn hơn 0')
        .max(100, 'Tuổi không lớn hơn 100')
        .nullable()
        .optional()
        .transform((val) => (val ? Number(val) : null)),
    ),

    sex: z.string().trim().nullable().optional(),

    status: z
      .string()
      .min(1, 'Trạng thái không được để trống')
      .trim()
      .max(20, 'Trạng thái không dài quá 20 ký tự')
      .trim()
      .nullable(),

    type: z
      .string()
      .min(1, 'Loại khách hàng không được để trống')
      .nullable()
      .optional(),

    img: z.string().optional().nullable(),

    owned: z.string().optional().nullable(),
  })
  .strict()

export const CustomerCreateRes = CustomerBodyRes.omit({ id: true })

export type CustomerCreateResType = z.TypeOf<typeof CustomerCreateRes>

export const CustomerUpdateRes = CustomerBodyRes.extend({
  user_id: z.number(),
  created_at: z.string(),
  updated_at: z.string(),
})

export type CustomerUpdateResType = z.TypeOf<typeof CustomerUpdateRes>

export const CustomerDeleteRes = CustomerBodyRes

export type CustomerDeleteResType = z.TypeOf<typeof CustomerDeleteRes>