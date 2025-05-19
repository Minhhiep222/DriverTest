import { CapabilitiesType, CapabilitiesUpdateResType } from "@/schemaValidations/capabilities.schema";
import http from "@/lib/http";
const capabilitiesRequestApi = {
    capa: (id: number) => http.get<CapabilitiesType>(`/capabilities/${id}`),
    update: (body: CapabilitiesUpdateResType) => http.put<CapabilitiesType>(`/capabilities/1`, body),
}
export default capabilitiesRequestApi;
