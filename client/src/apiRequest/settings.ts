import {SettingResType, SettingUpdateResType} from '@/schemaValidations/settings.schema'
  import http from '@/lib/http'
  
  const settingsRequestApi = {
    settings: () =>http.get<SettingResType>(`/settings`),
    
    update: (body: SettingUpdateResType[]) => http.put<SettingResType>(`/update/settings/all`, body),
  }
  
  export default settingsRequestApi
  