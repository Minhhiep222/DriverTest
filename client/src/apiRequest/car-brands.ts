import http from '@/lib/http'
import { CarBrandsResType } from '../schemaValidations/carbrands'
export default {
  getAll: () => http.get<CarBrandsResType>('/car-brands'),
  getUserCarBrands: () => http.get<CarBrandsResType>('user/car-brands'),
  addCarBrands: (body: {names: string[]}) => http.post<CarBrandsResType>('/car-brands', body),
  deleteCarBrand: (id: number) => http.delete<CarBrandsResType>(`/car-brands/${id}`),
}
