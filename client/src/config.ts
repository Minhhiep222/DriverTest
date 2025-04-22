import { z } from 'zod'

const configSchema = z.object({
  PORT: z.coerce.number().default(3000),
  VUE_APP_API_ENDPOINT: z.string(),
  SERVER_ENPOINT: z.string(),
})

const configProject = configSchema.safeParse({
  PORT: 3000,
  VUE_APP_API_ENDPOINT: 'http://127.0.0.1:8000/api',
  SERVER_ENPOINT: 'http://127.0.0.1:8000/',
})

if (!configProject.success) {
  console.error(configProject.error.issues)
  throw new Error('Các giá trị khai báo trong file .env không hợp lệ')
}

const envConfig = configProject.data
export default envConfig
