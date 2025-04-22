<template>
  <div class="w-full p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Xét Duyệt Chương Trình</h1>
    </div>
    <div class="min-h-full flex justify-end mb-2">
      <a-pagination
        v-model:current="page"
        v-model:page-size="per_page"
        :page-size-options="pageSizeOptions"
        :total="totalRecord"
        show-size-changer
        @change="handlePageChange"
        @showSizeChange="onShowSizeChange">
        <template #buildOptionText="props">
          <span v-if="props.value !== '100'">{{ props.value }} bảng</span>
          <span v-else>100 bảng</span>
        </template>
      </a-pagination>
    </div>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full bg-white">
        <thead
          class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
          <tr>
            <th class="py-3 px-2 text-left">STT</th>
            <th class="py-3 px-2 text-left">Hình ảnh</th>
            <th class="py-3 px-2 text-left">Tên chương trình</th>
            <th class="py-3 px-2 text-left">Địa chỉ</th>
            <th class="py-3 px-2 text-left">Thời gian bắt đầu</th>
            <th class="py-3 px-2 text-left">Thời gian kết thúc</th>
            <th class="py-3 px-2 text-left">Liên hệ</th>
            <th class="py-3 px-2 text-left">TRẠNG THÁI</th>
            <th class="py-3 px-2 text-left">ACTION</th>
          </tr>
        </thead>
        <tbody
          v-if="programs.length > 0"
          class="text-gray-600 text-sm font-light">
          <tr
            v-for="(item, index) in programs"
            :key="index"
            class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer">
            <td class="text-center px-2 font-bold">{{ index + 1 }}</td>
            <td class="px-1 text-left whitespace-nowrap">
              <img
                alt="Avatar"
                class="w-10 h-10 rounded-full"
                height="40"
                :src="image + item?.images[0]?.path"
                width="40"
                @error="handleImageError" />
            </td>
            <td class="px-2 text-left">{{ item?.name }}</td>
            <td class="py-3 px-2 text-left">{{ item?.location }}</td>
            <td class="py-3 px-2 text-left">{{ item?.start_time }}</td>
            <td class="py-3 px-2 text-left">{{ item?.end_time }}</td>
            <td class="py-3 px-2 text-left">{{ item?.contact }}</td>
            <td class="py-3 px-2 text-left">
              <span
                v-if="item?.status === 'Active'"
                class="bg-green-200 text-green-600 py-1 px-4 rounded-full text-xs">
                {{ item?.status }}
              </span>
              <span
                v-else
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">
                {{ item?.status }}
              </span>
            </td>
            <td>
              <a-button
                class="bg-green-500 text-white"
                @click="handDetail(item)"
                >Xem</a-button
              >
              <a-button
                class="bg-blue-500 text-white"
                @click="() => handleConfirm(item)"
                >Duyệt</a-button
              >
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="15" class="text-center py-8">
              <a-empty />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div>
    <Comfirm
      v-model="openConfirm"
      :drive="driveConfirm"
      @success="handleGetDriver" />
  </div>
</template>

<script lang="ts" setup>
  import driverRequestApi from '@/apiRequest/driver';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import {handleImageError} from '@/lib/utils';
  import router from '@/router';
  import {
    DriverResType,
    DriverUpdateResType,
    DriveComfirmResType,
  } from '@/schemaValidations/driver.schema';
  import {onMounted, ref} from 'vue';
  import Comfirm from './[handle]/Comfirm.vue';

  const pageSizeOptions = ref<string[]>(['10', '20', '30', '40', '50', '100']);
  const programs = ref<DriverResType['data']>([]);
  const filters = ref<DriverResType['data'][0]>({});
  const imageLoaded = ref<boolean>(true);
  const driversUpdate = ref<DriverUpdateResType>();

  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const key = ref<string>('');
  const image = ref(LINK_TO_STORAGE);
  const open = ref<boolean>(false);
  const update = ref<boolean>(false);
  const openConfirm = ref<boolean>(false);
  const driveConfirm = ref<DriveComfirmResType>();

  const handleConfirm = (data: DriveComfirmResType) => {
    openConfirm.value = true;
    driveConfirm.value = data;
  };

  const handDetail = (program) => {
    router.push(`/${program.id}/reviews`);
  };

  const handlePageChange = () => {
    handleGetDriver();
  };

  const onShowSizeChange = (current: number, pageSize: number) => {
    page.value = current;
    per_page.value = pageSize;
    handleGetDriver();
  };

  const handleGetDriver = async () => {
    try {
      //Call api
      const body = {
        page: page.value,
        per_page: per_page.value,
        key: key.value,
        filters: filters.value,
      };
      const result = await driverRequestApi.programAdmin(body);
      programs.value = result.payload.data;
      totalRecord.value = result.payload.totalRecord;
    } catch (error) {
      console.error('error', error);
    }
  };

  onMounted(() => {
    handleGetDriver();
  });
</script>
