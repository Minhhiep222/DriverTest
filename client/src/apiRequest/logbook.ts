import {
  LogBookResType,
  LogBookCreateResType,
  LogBookUpdateType,
  TimeBookResType
} from '@/schemaValidations/logbook.schema'
import http from '@/lib/http'

const logbookrRequestApi = {
  logbook: (body: {
    page: number
    per_page: number
    key: string
    driver_test_id?: string
  }) =>
    http.get<LogBookResType>(
      `/books?search=${body.key}&page=${body.page}&per_page=${body.per_page
      }&driver_test_id=${body.driver_test_id || ''}`
    ),

  create: (body: LogBookCreateResType) => http.post<LogBookResType>('/books', body),

  update: (body: LogBookUpdateType) => http.put<LogBookResType>(`/books/${body.id}`, body),

  search: (body: { page: number; per_page: number; key: string }) =>
    http.get<LogBookResType>(
      `/customers?search=${body.key}&page=${body.page}&per_page=${body.per_page}`
    ),
  check: (body: { id: number, date_drive: string }) => http.get<TimeBookResType>(`/checks/capabilities?driver_test_id=${body.id}&date_drive=${body.date_drive}`)
}

export default logbookrRequestApi
