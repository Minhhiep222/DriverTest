import { z } from 'zod'

export const UserRes = z
  .object({
    data: z.array(
      z.object({
        id: z.number(),
        account_id: z.number(),
        logo: z.string(),
        fullname: z.string(),
        shortname: z.string(),
        email: z.string(),
        phone: z.string(),
        MST: z.string(),
        address: z.string(),
        website: z.string(),
        status: z.string(),
      }),
    ),
    message: z.string(),
    totalRecord: z.number(),
  })
  .strict()

export type UserResType = z.TypeOf<typeof UserRes>

export const UserBodyRes = z
  .object({
    id: z.number().nullable().optional(),
    fullname: z
      .string({
        message: 'Họ và tên không được để trống', // Thêm message cho required
        invalid_type_error: 'Họ và tên phải là chuỗi',
      })
      .min(1, 'Họ và tên không được để trống')
      .max(50, 'Họ và tên không dài quá 50 ký tự'),

    shortname: z
      .string({
        message: 'Tên ngắn không được để trống',
      })
      .min(1, 'Tên ngắn không được để trống')
      .max(50, 'Tên ngắn không dài quá 50 ký tự'),

    email: z
      .string({
        message: 'Email không được để trống',
      })
      .email('Định dạng email không hợp lệ')
      .min(1, 'Email được để trống')
      .max(50, 'Email không dài quá 50 ký tự'),

    phone: z
      .string({ message: 'Số điện thoại không được để trống' })
      .regex(
        /^(0[1-9]\d{8,9}|(\+84|0)[1-9]\d{8}|\+[1-9]\d{1,14})$/,
        'Số điện thoại không hợp lệ',
      )
      .min(10, 'Số điện thoại phải có ít nhất 10 ký tự')
      .max(20, 'Số điện thoại không dài quá 20 ký tự'),
    MST: z.preprocess(
      (val) => {
        if (val === '') return undefined
        return val
      }, z
        .string()
        .regex(/^[0-9]+$/, 'Mã số thuế không hợp lệ')
        .min(10, 'Mã số thuế phải có ít nhất 10 ký tự')
        .max(20, 'Mã số thuế không dài quá 20 ký tự')
        .optional()
        .nullable()),

    address: z
      .string({
        message: 'Địa chỉ không được để trống',
      })
      .min(1, 'Địa chỉ không được để trống')
      .max(100, 'Địa chỉ không dài quá 100 ký tự'),

    status: z
      .string({
        message: 'Trạng thái không được để trống',
      })
      .min(1, 'Trạng thái không được để trống'),

    description: z
      .string()
      .max(1000, 'Mô tả không được quá 1000 ký tự')
      .optional()
      .nullable(),

    website: z.preprocess(
      (val) => {
        if (val === '') return undefined
        return val
      },
      z
        .string()
        .url('Định dạng website không hợp lệ')
        .max(255, 'Tên website không dài quá 255 ký tự')
        .trim()
        .optional()
        .nullable(),
    ),

    logo: z.string().optional().nullable(),

    image: z.string().optional().nullable(),

  })
  .strict()

export const UserCreateRes = UserBodyRes.omit({ id: true })

export type UserCreateResType = z.TypeOf<typeof UserCreateRes>

export const UserUpdateRes = UserBodyRes.extend({
  account_id: z.number().nullable().optional(),
  created_at: z.string().nullable().optional(),
  updated_at: z.string().nullable().optional(),
})

export type UserUpdateResType = z.TypeOf<typeof UserUpdateRes>

export const UserDeleteRes = UserBodyRes

export type UserDeleteResType = z.TypeOf<typeof UserDeleteRes>