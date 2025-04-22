<template>
  <div class="p-8">
    <div class="flex justify-between mb-6 items-center space-x-4">
      <!-- <Search v-model="key" @success="handleGetCustomer" /> -->
      <div class="text-2xl font-bold capitalize">Danh sách khách hàng</div>
    </div>
    <!-- Search Box -->
    <div class="search-box">
      <div class="search-item">
        <label for="customerName">Tên Khách Hàng:</label>
        <input
          id="customerName"
          type="text"
          v-model="filters.fullname"
          placeholder="Nhập tên khách hàng" />
      </div>

      <div class="search-item">
        <label for="customerType">Loại Khách Hàng:</label>
        <select v-model="filters.type" id="customerType">
          <option value="">-- Chọn loại --</option>
          <option value="normal">Thường</option>
          <option value="vip">VIP</option>
        </select>
      </div>

      <div class="search-item">
        <label for="phone">Số Điện Thoại:</label>
        <input
          id="phone"
          type="text"
          v-model="filters.phone"
          placeholder="Nhập số điện thoại" />
      </div>

      <div class="search-item">
        <label for="email">Email:</label>
        <input
          id="email"
          type="text"
          v-model="filters.email"
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

      <div class="search-item">
        <label for="region">Khu Vực:</label>
        <select v-model="filters.area" id="region">
          <option value="">-- Chọn khu vực --</option>
          <option value="north">Miền Bắc</option>
          <option value="central">Miền Trung</option>
          <option value="south">Miền Nam</option>
        </select>
      </div>

      <div class="search-item">
        <label for="income">Thu Nhập:</label>
        <input
          id="income"
          v-model="filters.income"
          type="text"
          placeholder="Nhập mức thu nhập" />
      </div>

      <div class="search-item">
        <label for="age">Độ Tuổi:</label>
        <select v-model="filters.age" id="age">
          <option value="">-- Chọn độ tuổi --</option>
          <option value="18-25">18 - 25</option>
          <option value="26-35">26 - 35</option>
          <option value="36-50">36 - 50</option>
          <option value="50+">Trên 50</option>
        </select>
      </div>

      <div class="search-item">
        <label for="gender">Giới Tính:</label>
        <select v-model="filters.sex" id="gender">
          <option value="">-- Chọn giới tính --</option>
          <option value="male">Nam</option>
          <option value="female">Nữ</option>
          <option value="other">Khác</option>
        </select>
      </div>

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
        + Thêm Khách Hàng
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
            <th>STT</th>
            <th class="py-3 px-2 text-left">Avatar</th>
            <th class="py-3 px-2 text-left">Họ &amp; Tên</th>
            <th class="py-3 px-2 text-left">Giới Tính</th>
            <th class="py-3 px-2 text-left">Gia đình</th>
            <th class="py-3 px-2 text-left">Sở Thích</th>
            <th class="py-3 px-2 text-left">Số Điện Thoại</th>
            <th class="py-3 px-2 text-left">Mail</th>
            <th class="py-3 px-2 text-left">Địa chỉ</th>
            <th class="py-3 px-2 text-left">Độ Tuổi</th>
            <th class="py-3 px-2 text-left">Sở hữu</th>
            <th class="py-3 px-2 text-left">Thu Nhập</th>
            <th class="py-3 px-2 text-left">Loại KH</th>
            <th class="py-3 px-2 text-left">Trạng Thái</th>
            <th class="py-3 px-2 text-left">Hành Động</th>
          </tr>
        </thead>
        <tbody v-if="data.length > 0" class="text-gray-600 text-sm font-light">
          <tr
            v-for="(customer, index) in data"
            :key="index"
            class="border-b border-gray-200 hover:bg-gray-100">
            <td class="text-center px-2 font-bold">{{ index + 1 }}</td>
            <td class="py-3 px-2">
              <img
                :src="image + customer?.img"
                alt="logo"
                class="w-10 h-10 rounded-full"
                height="40"
                width="40"
                @error="handleImageError" />
            </td>
            <td class="py-3 px-2">{{ customer?.fullname }}</td>
            <td class="py-3 px-2">{{ customer?.sex }}</td>
            <td class="py-3 px-2">{{ customer?.members }}</td>
            <td class="py-3 px-2">{{ customer?.hobbit }}</td>
            <td class="py-3 px-2">{{ customer?.phone }}</td>
            <td class="py-3 px-2">{{ customer?.email }}</td>
            <td class="py-3 px-2">{{ customer?.address }}</td>
            <td class="py-3 px-2">{{ customer?.age }}</td>
            <td class="py-3 px-2">{{ customer?.owned }}</td>
            <td class="py-3 px-2">{{ customer?.income }}</td>
            <td class="py-3 px-2">{{ customer?.type }}</td>
            <td class="py-3 px-2">
              <span
                v-if="customer?.status === 'Active'"
                class="bg-green-200 text-green-600 py-1 px-2 rounded-full text-xs">
                {{ customer?.status }}
              </span>
              <span
                v-else
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">
                {{ customer?.status }}
              </span>
            </td>
            <td class="py-3 px-2">
              <div class="flex item-center justify-center">
                <button
                  class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110"
                  @click="handleUpdate(customer)">
                  <EditOutlined />
                </button>
                <button
                  class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                  @click="handleDelete(customer)">
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
    <Create v-model="open" :customer="null" @success="handleGetCustomer" />
    <Update
      v-model="openUpdate"
      :customer="customer"
      @success="handleGetCustomer" />
    <Delete
      v-model="openDelete"
      :customer="customerDelete"
      @success="handleGetCustomer" />
  </div>
</template>

<script lang="ts" setup>
  import customerRequestApi from '@/apiRequest/customer';
  import '@/assets/customermngt.css';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import {handleImageError} from '@/lib/utils';
  import {
    CustomerDeleteResType,
    CustomerResType,
    CustomerUpdateResType,
  } from '@/schemaValidations/customer.schema';
  import {DeleteOutlined, EditOutlined} from '@ant-design/icons-vue';
  import {onMounted, ref, watch} from 'vue';
  import Create from './[handle]/AddCustomer.vue';
  import Delete from './[handle]/DeleteCustomer.vue';
  import Update from './[handle]/EditCustomer.vue';
  import Search from './[handle]/SearchCustomer.vue';

  const data = ref<CustomerResType['customer']>([]);
  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const pageSizeOptions = ref<string[]>(['10', '20', '30', '40', '50', '100']);
  const image = ref(LINK_TO_STORAGE);
  const key = ref<string>('');
  const open = ref<boolean>(false);
  const openUpdate = ref<boolean>(false);
  const openDelete = ref<boolean>(false);
  const customer = ref<CustomerUpdateResType>();
  const customerDelete = ref<CustomerDeleteResType>();
  const filters = ref<CustomerResType['customer'][0]>({});

  const showModal = () => {
    open.value = true;
  };

  const handleUpdate = (data: CustomerUpdateResType) => {
    openUpdate.value = true;
    customer.value = data;
  };

  const handleDelete = (data: CustomerDeleteResType) => {
    openDelete.value = true;
    customerDelete.value = data;
  };

  const handlePageChange = () => {
    handleGetCustomer();
  };

  const onShowSizeChange = (current: number, pageSize: number) => {
    page.value = current;
    per_page.value = pageSize;
    handleGetCustomer();
  };

  const handleRefresh = () => {
    filters.value = {};
    handleGetCustomer();
  };

  const handleSearch = () => {
    handleGetCustomer();
  };

  watch(
    key,
    (newValue) => {
      key.value = newValue;
    },
    {immediate: true}
  );

  //Dùng để lấy data customer
  const handleGetCustomer = async () => {
    try {
      const body = {
        page: page.value,
        per_page: per_page.value,
        key: key.value,
        filter: filters.value,
      };

      console.log('body', body);
      const result = await customerRequestApi.customers(body);
      // Kiểm tra toàn bộ response
      data.value = result.payload.customer;
      totalRecord.value = result.payload.totalRecord;
    } catch (error) {
      console.error('Error fetching customers:', error);
    }
  };

  onMounted(() => {
    handleGetCustomer();
  });
</script>
