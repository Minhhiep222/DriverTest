import { UserResType, UserCreateResType, UserUpdateResType, UserDeleteResType } from "@/schemaValidations/user.schema";
import http from "@/lib/http";
const users = (params: UserResType['data'][0]) => {
    // Build query string from params, filtering out undefined values
    const queryParams = Object.entries(params)
        .filter(([_, value]) => value !== undefined)
        .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
        .join('&');

    return queryParams;
};
const userRequestApi = {
    users: (body: { page: number, per_page: number, key: string, filters: UserResType['data'][0] }) =>
        http.get<UserResType>(`/users?search=${body.key}&page=${body.page}&per_page=${body.per_page}&${users(body.filters)}`),
    create: (body: UserCreateResType) => http.post<UserResType>('users', body),
    update: (body: UserUpdateResType) => http.put<UserResType>(`users/${body.id}`, body),
    delete: (body: UserDeleteResType) => http.delete<UserResType>(`users/${body.id}`),
    search: (body: { page: number, per_page: number, key: string }) => http.get<UserResType>(`/users?&search=${body.key}&page=${body.page}&per_page=${body.per_page}`),
}

export default userRequestApi;