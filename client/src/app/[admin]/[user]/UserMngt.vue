<template>
  <!-- Main Content -->
  <div class="w-full p-8">
    <div class="flex justify-between items-center mb-6">
      <!-- <Search v-model="key" @success="handleGetUser" /> -->
      <h1 class="text-2xl font-bold">Quản Lý Thông Tin Người Dùng</h1>
    </div>
    <!-- Search Box -->
    <div class="search-box">
      <div class="search-item">
        <label for="showroomName">Tên Showroom:</label>
        <input
          id="showroomName"
          v-model="filters.fullname"
          type="text"
          placeholder="Nhập tên Showroom" />
      </div>

      <div class="search-item">
        <label for="shortName">Tên Rút Gọn:</label>
        <input
          id="shortName"
          v-model="filters.shortname"
          type="text"
          placeholder="Nhập tên rút gọn" />
      </div>

      <div class="search-item">
        <label for="mst">Mã Số Thuế (MST):</label>
        <input
          id="mst"
          v-model="filters.MST"
          type="text"
          placeholder="Nhập MST" />
      </div>

      <div class="search-item">
        <label for="phone">Số Điện Thoại:</label>
        <input
          id="phone"
          v-model="filters.phone"
          type="text"
          placeholder="Nhập số điện thoại" />
      </div>

      <div class="search-item">
        <label for="email">Email:</label>
        <input
          id="email"
          v-model="filters.email"
          type="text"
          placeholder="Nhập email" />
      </div>

      <div class="search-item">
        <label for="status">Trạng Thái:</label>
        <select v-model="filters.status" id="status">
          <option value="">-- Chọn trạng thái --</option>
          <option value="Active">Đang hoạt động</option>
          <option value="Inactive">Không hoạt động</option>
        </select>
      </div>

      <div class="w-full flex justify-center gap-2">
        <a-button @click="handleRefresh" class="">Làm Mới</a-button>
        <a-button @click="handleSearch" type="primary" class="bg-green-500"
          >Tìm Kiếm</a-button
        >
      </div>
    </div>

    <div class="flex items-center space-x-4 pt-2 pb-2 justify-end">
      <button
        @click="showModal"
        class="bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-400">
        + Thêm Showroom
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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full bg-white">
        <thead
          class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
          <tr>
            <th class="py-3 px-2 text-left">STT</th>
            <th class="py-3 px-2 text-left">LOGO</th>
            <th class="py-3 px-2 text-left">SHOWROOM</th>
            <th class="py-3 px-2 text-left">TÊN NGẮN</th>
            <th class="py-3 px-2 text-left">MST</th>
            <th class="py-3 px-2 text-left">WEBSITE</th>
            <th class="py-3 px-2 text-left">EMAIL</th>
            <th class="py-3 px-2 text-left">PHONE</th>
            <th class="py-3 px-2 text-left">ADDRESS</th>
            <th class="py-3 px-2 text-left">TRẠNG THÁI</th>
            <th class="py-3 px-2 text-left">ACTION</th>
          </tr>
        </thead>
        <tbody v-if="data.length > 0" class="text-gray-600 text-sm font-light">
          <tr
            v-for="(user, index) in data"
            :key="index"
            class="border-b border-gray-200 hover:bg-gray-100">
            <td class="text-center px-2 font-bold">{{ index + 1 }}</td>
            <td class="px-1 text-left whitespace-nowrap">
              <img
                alt="Avatar"
                class="w-10 h-10 rounded-full"
                height="40"
                :src="image + user?.logo"
                width="40"
                @error="handleImageError" />
            </td>
            <td class="px-2 text-left">{{ user?.fullname }}</td>
            <td class="py-3 px-2 text-left">{{ user?.shortname }}</td>
            <td class="py-3 px-2 text-left">{{ user?.MST }}</td>
            <td class="py-3 px-2 text-left">{{ user?.website }}</td>
            <td class="py-3 px-2 text-left">{{ user?.email }}</td>
            <td class="py-3 px-2 text-left">{{ user?.phone }}</td>
            <td class="py-3 px-2 text-left">{{ user?.address }}</td>
            <td class="py-3 px-2 text-left">
              <span
                v-if="user?.status === 'Active'"
                class="bg-green-200 text-green-600 py-1 px-4 rounded-full text-xs">
                {{ user?.status }}
              </span>
              <span
                v-else
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">
                {{ user?.status }}
              </span>
            </td>
            <td class="py-3 px-6 text-left">
              <div class="flex item-center justify-center">
                <button
                  class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110"
                  @click="() => handleUpdate(user)">
                  <EditOutlined />
                </button>
                <button
                  class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                  @click="() => handleDelete(user)">
                  <DeleteOutlined class="text-red-500" />
                </button>
              </div>
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
    <Create v-model="open" @success="handleGetUser" />
    <Update v-model="openUpdate" :user="user" @success="handleGetUser" />
    <Delete v-model="openDelete" :user="userDelete" @success="handleGetUser" />
  </div>
</template>

<script lang="ts" setup>
  import userRequestApi from '@/apiRequest/user';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import {handleImageError} from '@/lib/utils';
  import {
    UserDeleteResType,
    UserResType,
    UserUpdateResType,
  } from '@/schemaValidations/user.schema';
  import {DeleteOutlined, EditOutlined} from '@ant-design/icons-vue';
  import {onMounted, ref, watch} from 'vue';
  import Create from './[handle]/Create.vue';
  import Delete from './[handle]/Delete.vue';
  import Search from './[handle]/Search.vue';
  import Update from './[handle]/Update.vue';

  const data = ref<UserResType['data']>([]);
  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const pageSizeOptions = ref<string[]>(['10', '20', '30', '40', '50', '100']);
  const image = ref(LINK_TO_STORAGE);
  const key = ref<string>('');
  const open = ref<boolean>(false);
  const openUpdate = ref<boolean>(false);
  const openDelete = ref<boolean>(false);
  const user = ref<UserUpdateResType>();
  const userDelete = ref<UserDeleteResType>();
  const filters = ref<UserResType['data'][0]>({});
  const showModal = () => {
    open.value = true;
  };

  const handleUpdate = (data: UserUpdateResType) => {
    openUpdate.value = true;
    user.value = data;
  };

  const handleDelete = (data: UserDeleteResType) => {
    openDelete.value = true;
    userDelete.value = data;
  };

  const handlePageChange = () => {
    handleGetUser();
  };

  const onShowSizeChange = (current: number, pageSize: number) => {
    page.value = current;
    per_page.value = pageSize;
    handleGetUser();
  };

  const handleRefresh = () => {
    filters.value = {};
    handleGetUser();
  };

  const handleSearch = () => {
    handleGetUser();
  };

  watch(
    key,
    (newValue) => {
      key.value = newValue;
    },
    {immediate: true}
  );

  //Dùng để lấy data user
  //async dùng để sử lý bất đồng bộ cho single thread
  const handleGetUser = async () => {
    try {
      //Call api
      const body = {
        page: page.value,
        per_page: per_page.value,
        key: key.value,
        filters: filters.value,
      };
      const result = await userRequestApi.users(body);
      data.value = result.payload.data;
      totalRecord.value = result.payload.totalRecord;
      console.log('result', result);
    } catch (error) {
      console.error('error', error);
    }
  };

  onMounted(() => {
    handleGetUser();
  });
</script>

<style>
  @media (max-width: 768px) {
    table {
      width: 100%;
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }

    th,
    td {
      padding: 8px;
      font-size: 14px;
    }

    .flex {
      flex-direction: column;
    }

    .w-4 {
      width: 20px;
      height: 20px;
    }

    .text-2xl {
      font-size: 1.5rem;
    }

    .bg-white.shadow-md {
      border-radius: 0;
      box-shadow: none;
    }

    .space-x-4 {
      gap: 10px;
    }

    .hover\\:scale-110:hover {
      transform: none;
    }

    .min-h-full.flex.justify-end {
      justify-content: center;
    }
  }

  /* ======= Search Box Styles ======= */
  .search-box {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
    justify-content: flex-start;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
  }

  .search-item {
    display: flex;
    flex-direction: column;
    width: calc(33.333% - 10px);
    min-width: 200px;
  }

  .search-item label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
  }

  .search-item input,
  .search-item select {
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    background-color: #f9fafb;
    transition: border-color 0.3s ease-in-out, box-shadow 0.2s;
  }

  .search-item input:focus,
  .search-item select:focus {
    border-color: #007bff;
    outline: none;
    background: #fff;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
  }

  .search-buttons {
    display: flex;
    justify-content: center;
    width: 100%;
    gap: 15px;
    margin-top: 10px;
  }

  .search-buttons button {
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
  }

  .search-buttons .reset-btn {
    background: #f44336;
    color: white;
  }

  .search-buttons .reset-btn:hover {
    background: #d32f2f;
  }

  .search-buttons .search-btn {
    background: #007bff;
    color: white;
  }

  .search-buttons .search-btn:hover {
    background: #0056b3;
  }

  @media (max-width: 1024px) {
    .search-item {
      width: calc(50% - 10px);
    }
  }

  @media (max-width: 768px) {
    .search-box {
      flex-direction: column;
      align-items: stretch;
    }

    .search-item {
      width: 100%;
    }

    .search-buttons {
      flex-direction: row;
    }

    .search-buttons button {
      width: auto;
    }
  }

  @media (max-width: 480px) {
    .search-buttons {
      flex-direction: column;
    }

    .search-buttons button {
      width: 100%;
    }
  }
</style>
