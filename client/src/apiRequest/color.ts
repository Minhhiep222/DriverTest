import http from '@/lib/http'
import { ColorResType } from '../schemaValidations/color'

export default {
  getAll: () => http.get<ColorResType>('/colors'),
  getUserColor: () => http.get<ColorResType>('user/colors'),
  addColors: (body: { names: string[] }) =>
    http.post<ColorResType>('/colors', body),
  deleteColor: (id: number) => http.delete<ColorResType>(`/colors/${id}`),
}
