<template>
  <a-modal
    v-model:open="props.modelValue"
    title="Sửa khách hàng"
    @cancel="handleCancel"
    :footer="null"
    class="min-w-full top-[0px] bottom-[0] p-4">
    <div class="p-4">
      <div class="mx-auto bg-white rounded-lg">
        <form class="grid grid-cols-2 gap-6" @submit.prevent="handleSubmit">
          <div>
            <div class="mb-1">
              <label class="text-gray-700">Tên Khách Hàng:</label>
              <input
                v-model="customer.fullname"
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
              <label class="block text-gray-700">Giới tính: </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.sex"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.sex}">
                <a-select-option value="male">Nam</a-select-option>
                <a-select-option value="female">Nữ</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.status" class="text-red-500 text-sm">{{
                  errors.status
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Số điện thoại: </label>
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
              <label class="block text-gray-700"> Email : </label>
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
              <label class="block text-gray-700"> Địa chỉ: </label>
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
              <label class="block text-gray-700">Kiểu khách hàng: </label>
              <a-select
                ref="select"
                v-model:value="customerInfo.type"
                style="width: 120px"
                class="min-w-full rounded"
                :class="{'border-red-500': errors.type}">
                <a-select-option value="normal">normal</a-select-option>
                <a-select-option value="vip">vip</a-select-option>
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
                type="number" />
              <div class="h-5">
                <span v-if="errors.income" class="text-red-500 text-sm">{{
                  errors.income
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"
                >Số thành viên gia đình:
              </label>
              <input
                v-model="customerInfo.members"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.members}"
                type="number" />
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
                <a-select-option value="yes">Có</a-select-option>
                <a-select-option value="no">Không</a-select-option>
              </a-select>
              <div class="h-5">
                <span v-if="errors.owned" class="text-red-500 text-sm">{{
                  errors.owned
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Trạng thái: </label>
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
          </div>
          <div class="w-full flex justify-end">
            <a-space>
              <a-button
                type="default"
                :size="size"
                @click="handleCancel"
                :loading="isSubmitting"
                >Hủy</a-button
              >
              <a-button
                type="primary"
                :size="size"
                html-type="submit"
                :loading="isSubmitting"
                >Lưu</a-button
              >
            </a-space>
          </div>
        </form>
      </div>
    </div>
  </a-modal>
</template>
<script lang="ts" setup>
  import {ref, watch, onMounted} from 'vue';
  import {
    CustomerUpdateResType,
    CustomerUpdateRes,
  } from '@/schemaValidations/customer.schema';
  import customerRequestApi from '@/apiRequest/customer';
  import {handleErrorApi} from '@/lib/utils';
  import toastify from '@/components/ui/toast';
  import useForm from '@/lib/use-form';

  const handleImageChange = (event: Event) => {
    const fileInput = event.target as HTMLInputElement;
    if (fileInput.files && fileInput.files[0]) {
      images.value = fileInput.files[0];
    }
  };

  const props = defineProps<{
    modelValue: boolean;
    customer: CustomerUpdateResType;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  const {notifyError, notifySuccess} = toastify();

  const errors = ref<CustomerUpdateResType>({});

  const customerInfo = ref<CustomerUpdateResType>({...props.customer});

  const {setError, reset, validateForm} = useForm(
    CustomerUpdateRes,
    customerInfo,
    errors
  );

  const images = ref<File>();
  const size = ref<'large'>('large');
  const isSubmitting = ref(false);

  watch(
    () => props.customer,
    () => {
      customerInfo.value = props.customer;
    },
    {deep: true}
  );

  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  const handleSubmit = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      const result = await customerRequestApi.update(customerInfo.value);

      notifySuccess(result.payload.message);
    //reset
      reset();

      images.value = null;
      //đống model
      emit('update:modelValue', false);

      emit('success');
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
    } finally {
      isSubmitting.value = false; 
      //dừng load
    }
  };

  onMounted(() => {
    console.log('Props customer:', props.customer);
  });
</script>
