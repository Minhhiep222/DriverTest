import http from '@/lib/http'
import {
  CustomerCreateResType,
  CustomerDeleteResType,
  CustomerResType,
  CustomerUpdateResType,
} from '@/schemaValidations/customer.schema'
const customers = (params: CustomerResType['customer'][0]) => {
  // Build query string from params, filtering out undefined values
  const queryParams = Object.entries(params)
    .filter(([_, value]) => value !== undefined)
    .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
    .join('&');

  return queryParams;
};
const customerRequestApi = {
  // Lấy danh sách khách hàng
  customers: (body: { page: number; per_page: number; key: string; filter: CustomerResType['customer'][0] }) =>
    http.get<CustomerResType>(
      `/customers?search=${body.key}&page=${body.page}&per_page=${body.per_page}&${customers(body.filter)}`,
    ),
  // Tạo khách hàng mới
  create: (body: CustomerCreateResType) =>
    http.post<CustomerResType>('/customers', body),
  // Cập nhật thông tin khách hàng
  update: (body: CustomerUpdateResType) =>
    http.put<CustomerResType>(`/customers/${body.id}`, body),
  // Xóa khách hàng
  delete: (body: CustomerDeleteResType) =>
    http.delete<CustomerResType>(`/customers/${body.id}`),
  // Tìm kiếm khách hàng (dựa trên key)
  search: (body: { page: number; per_page: number; key: string }) =>
    http.get<CustomerResType>(
      `/customers?search=${body.key}&page=${body.page}&per_page=${body.per_page}`,
    ),
}
export default customerRequestApi
