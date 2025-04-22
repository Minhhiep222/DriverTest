<template>
  <!-- Main Content -->
  <div class="w-full px-8">
    <div class="flex justify-between items-center mb-6">
      <!-- <div class="flex items-center space-x-4">
                <Search v-model="key" @success="handleGetLogBook" />
            </div> -->
    </div>
    <div class="min-h-full flex justify-between mb-2">
      <h1 class="text-2xl font-bold">DANH SÁCH ĐĂNG KÝ</h1>
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
    <div
      class="bg-white shadow-md rounded-lg"
      style="overflow-x: auto; overflow-y: auto">
      <table class="min-w-full bg-white mb-8">
        <thead
          class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
          <tr>
            <th class="py-3 px-2 text-left">STT</th>
            <th class="py-3 px-2 text-left">HỌ & TÊN</th>
            <th class="py-3 px-2 text-left">SỐ ĐIỆN THOẠI</th>
            <th class="py-3 px-2 text-left">THỜI GIAN LÁI THỬ</th>
            <th class="py-3 px-2 text-left">GHI CHÚ</th>
            <th class="py-3 px-2 text-left">TIẾP NHẬN</th>
          </tr>
        </thead>
        <tbody v-if="data.length > 0" class="text-gray-600 text-sm font-light">
          <tr
            v-for="(logbook, index) in data"
            :key="index"
            class="border-b border-gray-200 hover:bg-gray-100">
            <td class="text-center px-2 font-bold">{{ index + 1 }}</td>
            <td class="py-3 px-2 text-left">{{ logbook?.fullname }}</td>
            <td class="py-3 px-2 text-left">{{ logbook?.phone }}</td>
            <td class="py-3 px-2 text-left">{{ logbook?.time_drive }}</td>
            <td class="py-3 px-2 text-left">{{ logbook?.note }}</td>

            <td v-if="logbook?.status === 'Active'" class="py-3 px-2 text-left">
              <a-button
                type="primary"
                :size="size"
                html-type="submit"
                @click="handleCreate(logbook, logbook.id)"
                >Tiếp nhận</a-button
              >
            </td>
            <td
              v-if="logbook?.status === 'Inactive'"
              class="py-3 px-2 text-left">
              <a-button
                aria-disabled="true"
                :size="size"
                html-type="submit"
                disabled
                >Hoàn thành</a-button
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
  <Create v-model="open" :customer="customer" @success="handleSubmit" />
</template>

<script lang="ts" setup>
  import {onMounted, ref, watch} from 'vue';
  import {useRouter, RouteLocationNormalizedLoaded} from 'vue-router';
  import bookRequestApi from '@/apiRequest/logbook';
  import {LogBookResType} from '@/schemaValidations/logbook.schema';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import Create from '@/app/[admin]/[customer]/[handle]/AddCustomer.vue';
  import {
    DriverCreateResType,
    DriverCreateRes,
  } from '@/schemaValidations/driver.schema';

  const size = ref<SizeType>('large');

  //import Search from '@/app/driver/handle/Search.vue';

  const data = ref<LogBookResType['data']>([]);
  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const pageSizeOptions = ref<string[]>(['10', '20', '30', '40', '50', '100']);
  const key = ref<string>('');
  const customer = ref<DriverCreateResType>();
  const idBooking = ref<number>();

  const handleCreate = (data: DriverCreateResType, id: number) => {
    customer.value = data;
    idBooking.value = id;
    open.value = true;
  };

  const handleSubmit = async () => {
    try {
      const body = {
        id: idBooking.value,
        status: 'Inactive',
      };
      const result = await bookRequestApi.update(body);
      handleGetLogBook(parseInt(Array.isArray(id) ? id[0] : id));
    } catch (error) {
      console.error('Error:', error);
    }
  };

  const open = ref<boolean>(false);
  const props = defineProps<{
    params: RouteLocationNormalizedLoaded;
  }>();

  const id = props.params.params.id;

  const handlePageChange = () => {
    handleGetLogBook(parseInt(Array.isArray(id) ? id[0] : id));
  };

  const onShowSizeChange = (current: number, pageSize: number) => {
    page.value = current;
    per_page.value = pageSize;
    handleGetLogBook(parseInt(Array.isArray(id) ? id[0] : id));
  };

  watch(
    key,
    (newValue) => {
      key.value = newValue;
    },
    {immediate: true}
  );
  const handleGetLogBook = async (id: number) => {
    try {
      const body = {
        page: page.value,
        per_page: per_page.value,
        key: key.value,
        driver_test_id: String(id),
      };
      const result = await bookRequestApi.logbook(body);
      data.value = result.payload.data;
      totalRecord.value = result.payload.totalRecord;
    } catch (error) {
      console.error('Error:', error);
    }
  };

  onMounted(() => {
    handleGetLogBook(parseInt(Array.isArray(id) ? id[0] : id));
  });
</script>
