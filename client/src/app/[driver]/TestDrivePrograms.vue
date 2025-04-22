<template>
  <div class="test-drive-programs-container p-8">
    <!-- Search Box -->
    <div class="search-box">
      <div class="search-item">
        <label for="programCode">Tên Chương Trình:</label>
        <input
          id="programCode"
          v-model="filters.name"
          type="text"
          placeholder="Tên chương trình" />
      </div>
      <div class="search-item">
        <label for="programCode">Địa chỉ:</label>
        <input
          id="programCode"
          v-model="filters.location"
          type="text"
          placeholder="Địa chỉ chương trình" />
      </div>

      <div class="search-item">
        <label for="startDate">Từ Ngày:</label>
        <input id="startDate" v-model="filters.start_time" type="date" />
      </div>

      <div class="search-item">
        <label for="endDate">Ngày Kết Thúc:</label>
        <input id="endDate" v-model="filters.end_time" type="date" />
      </div>

      <!-- Trạng thái với danh sách lựa chọn -->
      <div class="search-item">
        <label for="status">Trạng Thái:</label>
        <select v-model="filters.status" id="status">
          <option value="">-- Chọn trạng thái --</option>
          <option value="Active">Đang diễn ra</option>
          <option value="Inactive">Kết thúc</option>
        </select>
      </div>

      <!-- <div class="search-item">
        <label for="brand">Hãng Xe:</label>
        <input
          id="brand"
          v-model="filters.showroom"
          type="text"
          placeholder="Nhập hãng xe" />
      </div> -->
<!-- 
      <div class="search-item">
        <label for="vehicleType">Dòng Xe:</label>
        <input
          id="vehicleType"
          v-model="filters.vehicle_type"
          type="text"
          placeholder="Nhập dòng xe" />
      </div> -->

      <div class="w-full flex justify-center gap-2">
        <a-button @click="handleRefresh" class="">Làm Mới</a-button>
        <a-button @click="handleSearch" type="primary" class="bg-green-500"
          >Tìm Kiếm</a-button
        >
      </div>
    </div>

    <div class="flex justify-end pb-2 pt-2">
      <button
        @click="showModal"
        class="bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-400">
        + Thêm chương trình
      </button>
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

    <div v-if="programs.length > 0" class="program-list">
      <div
        v-for="(program, index) in programs"
        :key="index"
        class="program-card"
        :class="{'free-program': index < 3}">
        <div class="card-header justify-between">
          <h3 class="program-name">{{ program.name.slice(0, 25) }}</h3>
          <span
            class="program-status"
            :class="{active: program?.status === 'Active'}">
            {{ program.status === 'Active' ? 'Kích Hoạt' : 'Tắt' }}
          </span>
        </div>
        <div class="program-content">
          <div class="program-image">
            <!-- thiếu trường -->
            <img
              :src="image + program?.images[0]?.path"
              :alt="program?.name"
              @error="handleImageError"
              :class="{
                'img-failed': true,
                'error-image-class': !imageLoaded,
              }" />
            <!-- <div class="overlay-content">
                            <div v-if="program?.color" class="program-color">
                                Màu: <span class="color-display" :style="{backgroundColor: program.color}"></span>
                            </div>
                        </div> -->
          </div>
          <div class="program-details">
            <p>
              <strong>Hãng xe:</strong> {{ program?.showroom.slice(0, 10) }}...
            </p>
            <p>
              <strong>Địa chỉ:</strong> {{ program?.location.slice(0, 40) }}...
            </p>
            <!-- <p>
              <strong>Dòng xe:</strong>
              <span>
                {{ program?.vehicle_type }}
              </span>
            </p> -->
            <p>
              <strong>Thời gian:</strong>
              {{ formatDateTime(program?.start_time) }} -
              {{ formatDateTime(program?.end_time) }}
            </p>
            <p>
              <!-- <strong>Liên hệ:</strong>
                             <a v-if="program?.contact.startsWith('http')" :href="program?.contact" target="_blank"
                                class="contact-link">
                                Form
                            </a>
                            <span v-else>{{ program?.contact }}</span> -->
            </p>
            <div v-if="program?.description" class="detailed">
              <strong>Mô tả chi tiết:</strong>
              <p>{{ program.description.slice(0, 50) }}...</p>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <span v-if="index >= 3" class="fee-text">
            Chương trình này có phí
          </span>
          <div class="action-buttons">
            <button class="detail-btn" @click="handDetail(program)">Xem</button>
            <button class="edit-btn" @click="() => handleUpdate(program)">
              Sửa
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="program-list">
      <a-empty />
    </div>

    <Create v-model="open" @success="handleGetDriver" />

    <Update
      v-model="update"
      @success="handleGetDriver"
      :program="driversUpdate" />
    <Verify v-model="verify" />
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
  } from '@/schemaValidations/driver.schema';
  import {onMounted, ref} from 'vue';
  import Create from './[handle]/Create.vue';
  import Update from './[handle]/Update.vue';
  import Verify from '@/app/[me]/Verify.vue';

  const programs = ref<DriverResType['data']>([]);
  const imageLoaded = ref<boolean>(true);
  const driversUpdate = ref<DriverUpdateResType>();
  const pageSizeOptions = ref<string[]>(['12', '24', '36', '48', '60', '100']);
  const totalRecord = ref(0);
  const per_page = ref(12);
  const page = ref(1);
  const key = ref<string>('');
  const image = ref(LINK_TO_STORAGE);
  const open = ref<boolean>(false);
  const update = ref<boolean>(false);
  const verify = ref<boolean>(false);
  const filters = ref<DriverResType['data'][0]>({});

  const handlePageChange = () => {
    handleGetDriver();
  };

  const onShowSizeChange = (current: number, pageSize: number) => {
    page.value = current;
    per_page.value = pageSize;
    handleGetDriver();
  };

  const handDetail = (program) => {
    router.push(`/${program.id}/log-books`);
  };

  const handleUpdate = (data: DriverUpdateResType) => {
    console.log('data', data);
    driversUpdate.value = data;
    update.value = true;
  };

  const showModal = () => {
    verifyInfo();
    const confirm = localStorage.getItem('verify');
    if (!confirm) {
      open.value = true;
    }
  };

  const formatDateTime = (dateTimeString) => {
    const date = new Date(dateTimeString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');

    return `${day}-${month}-${year} ${hours}:${minutes}`;
  };

  const handleRefresh = () => {
    filters.value = {};
    handleGetDriver();
  };

  const handleSearch = () => {
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
      const result = await driverRequestApi.programUser(body);
      programs.value = result.payload.data;
      totalRecord.value = result.payload.totalRecord;
    } catch (error) {
      console.error('error', error);
    }
  };

  const verifyInfo = () => {
    const confirm = localStorage.getItem('verify');
    if (confirm) {
      verify.value = true;
    }
  };

  onMounted(() => {
    handleGetDriver();
    verifyInfo();
  });
</script>

<style scoped>
  @import '../../assets/program.css';
</style>
