import { z } from "zod";

export const AccountRes = z.object({
  data: z.object({
    id: z.number(),
    phone: z.string(),
    status: z.string(),
    role: z.string()
  }),
  message: z.string()
}).strict()

export type AccountResType = z.TypeOf<typeof AccountRes>

export const InformaRes = z.object({
  data: z.object({
    id: z.number(),
    phone: z.string(),
    status: z.string(),
    role: z.string(),
    name: z.string(),
  }),
  message: z.string()
}).strict()

export type InformaResType = z.TypeOf<typeof InformaRes>