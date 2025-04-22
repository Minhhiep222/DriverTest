import axios from "axios";
import {
    RegisterBodyType,
    LoginBodyResType,
    LoginResType,
    RegisterResType,
    VerifyBodyResType,
    VerifyResType,
    AccountResType,
    ForgotBodyResType,
    VerifyOTPResType,
    MeResType,
    MeUpdateBodyResType
} from "@/schemaValidations/auth.schema";
import envConfig from "@/config";
import http from "@/lib/http";

const endpoint = envConfig.VUE_APP_API_ENDPOINT;

const authRequestApi = {
    register: (body: RegisterBodyType) => http.post<RegisterResType>(`/auth/register`, body),
    verify: (body: VerifyBodyResType) => http.post<LoginResType>(`/auth/register/verify`, body),
    resend: (body: VerifyBodyResType) => http.post<VerifyResType>(`/auth/register/resend-otp`, body),
    login: (body: LoginBodyResType) => http.post<LoginResType>(`/auth/login`, body),
    auth: () => http.get<LoginResType>(`/auth/check-auth`),
    me: () => http.get<MeResType>(`/auth/me`),
    update: (body: MeUpdateBodyResType) => http.post<MeResType>(`/auth/update`, body),
    fogot: (body: ForgotBodyResType) => http.post<ForgotBodyResType>(`/auth/forgotten`, body),
    verifyOTP: (body: VerifyOTPResType) => http.post<VerifyOTPResType>(`/auth/forgot/verify`, body),
    logout: (body: RegisterBodyType) => axios.post<RegisterBodyType>(`${endpoint}/api/auth/register`, body),
    refesh: (body: RegisterBodyType) => axios.post<RegisterBodyType>(`${endpoint}/api/auth/register`, body),
}

export default authRequestApi;