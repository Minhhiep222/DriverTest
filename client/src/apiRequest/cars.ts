import http from '@/lib/http'
import { CarResType } from '../schemaValidations/cars'
export default {
  getAll: () => http.get<CarResType>('/cars'),
  getUserCars: () => http.get<CarResType>('user/cars'),
  addCars: (body: { names: string[] }) => http.post<CarResType>('/cars', body),
  deleteCar: (id: number) => http.delete<CarResType>(`/cars/${id}`),
}
