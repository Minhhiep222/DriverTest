import { SettingResType, SettingUpdateResType } from '@/schemaValidations/setting.schema'
import http from '@/lib/http'

const settingRequestApi = {
  setting: (id: number) => http.get<SettingResType>(`/settings/${id}`),
  update: (body: SettingUpdateResType) => http.put<SettingResType>(`/update/settings/all`, body),
}

export default settingRequestApi
