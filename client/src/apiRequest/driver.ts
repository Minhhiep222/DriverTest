
import { DriverResType, DriverCreateResType, DriverUpdateResType, DriverReadResType, DriveComfirmResType } from "@/schemaValidations/driver.schema";
import http from "@/lib/http";

const drivers = (params: DriverResType['data'][0]) => {
    // Build query string from params, filtering out undefined values
    const queryParams = Object.entries(params)
        .filter(([_, value]) => value !== undefined)
        .map(([key, value]) => `${key}=${encodeURIComponent(String(value))}`)
        .join('&');

    return queryParams;
};


const userRequestApi = {
    drivers: (body: { page: number, per_page: number, key: string, filters: DriverResType['data'][0] }) =>
        http.get<DriverResType>(`/tests?search=${body.key}&page=${body.page}&per_page=${body.per_page}&${drivers(body.filters)}`),
    create: (body: DriverCreateResType) => http.post<DriverResType>('/tests', body),
    update: (body: DriverUpdateResType, id: number) => http.post<DriverResType>(`/tests/${id}`, body),
    program: (body: { page: number, per_page: number, key: string }) =>
        http.get<DriverResType>(
            `/programs/views?search=${body.key}&page=${body.page}&per_page=${body.per_page}`
        ),
    programUser: (body: { page: number, per_page: number, key: string, filters: DriverResType['data'][0] }) =>
        http.get<DriverResType>(
            `/tests?search=${body.key}&page=${body.page}&per_page=${body.per_page}&${drivers(body.filters)}`
        ),
    programAdmin: (body: { page: number, per_page: number, key: string, filters: DriverResType['data'][0] }) =>
        http.get<DriverResType>(
            `/admin/programs/views?search=${body.key}&page=${body.page}&per_page=${body.per_page}&${drivers(body.filters)}`
        ),
    show: (id: number) => http.get<DriverReadResType>(`/programs/deatail/${id}`),

    confirm: (body: DriveComfirmResType) => http.put<DriverReadResType>(`/admin/program/confirm/${body.id}`, body),

    // delete: (body: UserDeleteResType) => http.delete<UserResType>(`users/${body.id}`),
    // search: (body: { page: number, per_page: number, key: string }) => http.get<UserResType>(`/users?&search=${body.key}&page=${body.page}&per_page=${body.per_page}`),

}

export default userRequestApi;