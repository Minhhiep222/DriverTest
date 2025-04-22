import { data } from "autoprefixer";
import { z } from "zod";
import { UserUpdateRes } from "./user.schema";

export const LoginRes = z.object({
  data: z.object({
    token: z.string(),
    expiresAt: z.string(),
    account: z.object({
      id: z.number(),
      name: z.string(),
      email: z.string(),
      role: z.string()
    })
  }),
  message: z.string()
})

export type LoginResType = z.TypeOf<typeof LoginRes>;


export const LoginBodyRes = z
  .object({
    phone: z
      .string({
        required_error: "Tên đăng nhập không được để trống"
      })
      .min(10, { message: "Tên đăng nhập không họp lệ" })
      .max(50, { message: "Tên đăng nhập không hợp lệ" }),
    password: z
      .string({
        required_error: "Mật khẩu không được để trống"
      })
      .min(6, { message: "Mật khẩu chứa ít nhất 6 ký tự" })
      .max(20, { message: "Mật khẩu chứa nhiều nhất 20 ký tự" }),
  })
  .strict();

export type LoginBodyResType = z.TypeOf<typeof LoginBodyRes>;

export const RegisterBody = z
  .object({
    phone: z
      .string({
        required_error: "Tên đăng nhập không được để trống"
      })
      .min(10, { message: "Tên đăng nhập không họp lệ" })
      .max(50, { message: "Tên đăng nhập không hợp lệ" }),
    password: z
      .string({
        required_error: "Mật khẩu không được để trống"
      })
      .min(8, { message: "Mật khẩu chứa ít nhất 8 ký tự" })
      .max(20, { message: "Mật khẩu chứa nhiều nhất 20 ký tự" }),
  })
  .strict();

export type RegisterBodyType = z.infer<typeof RegisterBody>;

export const RegisterRes = z
  .object({
    status: z.string(),
    data: z.object({
      phone: z.string(),
      expires_in: z.number()
    }),
    message: z.string(),
  })
  .strict();

export type RegisterResType = z.infer<typeof RegisterRes>;

export const VerifyBodyRes = z.object({
  otp: z.string(),
  phone: z.string(),
  password: z.string()
});

export type VerifyBodyResType = z.infer<typeof VerifyBodyRes>

export type VerifyResType = z.infer<typeof RegisterRes>

export const ResendBodyRes = VerifyBodyRes.omit({ otp: true })

export type ResendBodyResType = z.infer<typeof ResendBodyRes>

export type ResendResType = z.infer<typeof RegisterRes>

export const AccountRes = z.object({
  data: z.object({
    id: z.number(),
    name: z.string(),
    email: z.string(),
    role: z.string()
  }),
})

export type AccountResType = z.infer<typeof AccountRes>

export const MeRes = z.object({
  data: z.object({
    id: z.number(),
    phone: z.string(),
    role: z.string(),
    status: z.string(),
    name: z.string(),
    details: z.object({
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
      description: z.string(),
    }),
  }),
  message: z.string()
})

export type MeResType = z.infer<typeof MeRes>

export const MeUpdateBodyRes = UserUpdateRes.omit({
  created_at: true,
  updated_at: true,
})

export type MeUpdateBodyResType = z.infer<typeof MeUpdateBodyRes>

export const ForgotBodyRes = z.object({
  phone: z.string({ required_error: "Vui lòng nhập tên đăng nhập" }).min(10, "Username chứa ít nhất 10 ký tự").max(50, "Tên đăng nhập không được dài quá 50 ký tự")
})

export type ForgotBodyResType = z.infer<typeof ForgotBodyRes>

export const VerifyOTPRes = z.object({
  phone: z.string({ required_error: "Vui lòng nhập tên đăng nhập" }).min(10, "Tên đăng nhập chứa ít nhất 10 ký tự").max(50, "Tên đăng nhập không được dài quá 50 ký tự"),
  otp: z.string({ required_error: "Vui lòng nhập mã OTP " }).max(10, "OTP chỉ chứa 6 ký tự")
})

export type VerifyOTPResType = z.infer<typeof VerifyOTPRes>