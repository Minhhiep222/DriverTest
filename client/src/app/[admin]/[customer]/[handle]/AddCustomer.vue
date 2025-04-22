<template>
  <a-modal
    v-model:open="props.modelValue"
    title="Thêm khách hàng"
    @cancel="handleCancel"
    :footer="null"
    class="min-w-full top-[0px] bottom-[0] p-4">
    <div class="p-4">
      <div class="mx-auto bg-white rounded-lg">
        <form class="grid grid-cols-2 gap-6" @submit.prevent="handleSubmit">
          <div>
            <div class="mb-1">
              <label class="text-gray-700"
                >Tên Khách hàng<span class="text-red-500">*</span> :</label
              >
              <input
                v-model="customerInfo.fullname"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.fullname}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.fullname" class="text-red-500 text-sm">
                  {{ errors.fullname }}
                </span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">
                Số điện thoại<span class="text-red-500">*</span>:
              </label>
              <input
                v-model="customerInfo.phone"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.phone}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.phone" class="text-red-500 text-sm">{{
                  errors.phone
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">
                Địa chỉ<span class="text-red-500">*</span> :
              </label>
              <input
                v-model="customerInfo.address"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.address}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.address" class="text-red-500 text-sm">{{
                  errors.address
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">Giới tính: </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.sex"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.sex}">
                <a-select-option value="male" selected="true"
                  >Nam</a-select-option
                >
                <a-select-option value="female">Nữ</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.sex" class="text-red-500 text-sm">{{
                  errors.sex
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">
                Email<span class="text-red-500">*</span> :
              </label>
              <input
                v-model="customerInfo.email"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.email}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.email" class="text-red-500 text-sm">{{
                  errors.email
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">Khu vực: </label>
              <input
                v-model="customerInfo.area"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.area}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.area" class="text-red-500 text-sm">{{
                  errors.area
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700"
                >Kiểu khách hàng<span class="text-red-500">*</span> :
              </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.type"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.type}">
                <a-select-option value="normal">Thường</a-select-option>
                <a-select-option value="vip">VIP</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.type" class="text-red-500 text-sm">{{
                  errors.type
                }}</span>
              </div>
            </div>
          </div>
          <div>
            <div class="mb-1">
              <label class="block text-gray-700">Sở thích: </label>
              <input
                v-model="customerInfo.hobbit"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.hobbit}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.hobbit" class="text-red-500 text-sm">{{
                  errors.hobbit
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700">Thu nhập: </label>
              <input
                v-model="customerInfo.income"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.income}"
                type="number"
                placeholder="vnđ" />
              <div class="h-5">
                <span v-if="errors.income" class="text-red-500 text-sm">{{
                  errors.income
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"
                >Số thành viên trong gia đình:
              </label>
              <input
                v-model="customerInfo.members"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.members}"
                type="number"
                value="0" />
              <div class="h-5">
                <span v-if="errors.members" class="text-red-500 text-sm">{{
                  errors.members
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700">Tuổi: </label>
              <input
                v-model="customerInfo.age"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.age}"
                type="number" />
              <div class="h-5">
                <span v-if="errors.age" class="text-red-500 text-sm">{{
                  errors.age
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Sở hữu xe: </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.owned"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.owned}">
                <a-select-option value="yes">yes</a-select-option>
                <a-select-option value="no">no</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.owned" class="text-red-500 text-sm">{{
                  errors.owned
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700">
                Trạng thái<span class="text-red-500">*</span> :
              </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.status"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.status}">
                <a-select-option value="Active">Active</a-select-option>
                <a-select-option value="Inactive">Inactive</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.status" class="text-red-500 text-sm">{{
                  errors.status
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Avatar: </label>
              <input
                id="imgInput"
                ref="fileInput"
                @change="handleAvatarChange"
                class="hidden"
                :class="{'border-red-500': errors.img}"
                type="file" />

              <div class="flex justify-start gap-1">
                <img
                  v-if="!customerInfo.img"
                  @click="() => triggerFileInput('imgInput')"
                  src="@/assets/images/default.png"
                  alt="Avatar preview"
                  class="max-w-[150px] h-[150px] border rounded cursor-pointer"
                  height="200"
                  width="200" />
                <img
                  v-if="customerInfo.img"
                  @click="() => triggerFileInput('imgInput')"
                  :src="customerInfo.img"
                  alt="Avatar preview"
                  class="max-w-[150px] h-[150px] border rounded cursor-pointer"
                  height="200"
                  width="200" />
              </div>
              <div class="h-5">
                <span v-if="errors.img" class="text-red-500 text-sm">{{
                  errors.img
                }}</span>
              </div>
            </div>
          </div>
          <div class="w-full flex justify-end">
            <a-space>
              <a-button
                type="default"
                :size="size"
                @click="handleCancel"
                :loading="isSubmitting">
                Hủy
              </a-button>
              <a-button
                type="primary"
                :size="size"
                html-type="submit"
                :loading="isSubmitting">
                Lưu
              </a-button>
            </a-space>
          </div>
        </form>
      </div>
    </div>
  </a-modal>
</template>

<script lang="ts" setup>
  import customerRequestApi from '@/apiRequest/customer';
  import toastify from '@/components/ui/toast';
  import useForm from '@/lib/use-form';
  import {handleErrorApi, triggerFileInput} from '@/lib/utils';
  import {
    CustomerCreateRes,
    CustomerCreateResType,
    CustomerUpdateResType,
  } from '@/schemaValidations/customer.schema';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import {onMounted, ref, watch} from 'vue';

  const props = defineProps<{
    modelValue: boolean;
    customer: CustomerUpdateResType;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  const {notifyError, notifySuccess} = toastify();

  const errors = ref<CustomerCreateResType>({});
  const customerInfo = ref<CustomerCreateResType>({
    status: 'Active',
  });
  const {setError, reset, validateForm} = useForm(
    CustomerCreateRes,
    customerInfo,
    errors
  );

  const images = ref<File>();
  const size = ref<SizeType>('large');
  const isSubmitting = ref(false);

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  // Xử lý thay đổi avatar
  const handleAvatarChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
      images.value = file;
      customerInfo.value.img = URL.createObjectURL(file);
    }
  };

  watch(
    () => props.customer,
    () => {
      customerInfo.value.fullname = props.customer.fullname;
      customerInfo.value.phone = props.customer.phone;
    },
    {deep: true}
  );
  function formatIncome(e) {
    const value = e.target.value.replace(/,/g, ''); // Bỏ dấu phẩy
    this.customerInfo.income = parseFloat(value) || null; // Lưu số thực
    this.formattedIncome = value.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Định dạng lại
  }
  const handleSubmit = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      const formData = new FormData();

      for (const [key, value] of Object.entries(customerInfo.value)) {
        formData.append(key, value.toString());
      }

      if (images.value) {
        formData.append('image', images.value);
      }

      const result = await customerRequestApi.create(
        formData as CustomerCreateResType
      );

      notifySuccess(result.payload.message);
      // Reset form
      reset();
      images.value = null;

      // Close modal/dialog
      emit('update:modelValue', false);

      // Emit success event để parent refresh data
      emit('success');
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
    } finally {
      isSubmitting.value = false; // Stop loading
    }
  };
</script>
