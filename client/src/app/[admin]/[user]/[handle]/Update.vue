<template>
  <a-modal
    v-model:open="props.modelValue"
    title="Sửa người dùng"
    @cancel="handleCancel"
    :footer="null"
    class="min-w-full top-[0px] bottom-[0] p-4">
    <div class="p-4">
      <div class="mx-auto bg-white rounded-lg">
        <form class="grid grid-cols-2 gap-6" @submit.prevent="handleSubmit">
          <div>
            <div class="mb-1">
              <label class="text-gray-700"
                >Họ & Tên <span class="text-red-500">*</span> :</label
              >
              <input
                v-model="userInfo.fullname"
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
                Tên rút gọn <span class="text-red-500">*</span> :
              </label>
              <input
                v-model="userInfo.shortname"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.shortname}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.shortname" class="text-red-500 text-sm">{{
                  errors.shortname
                }}</span>
              </div>
            </div>

            <div class="mb-1">
              <label class="block text-gray-700">
                SDT <span class="text-red-500">*</span> :
              </label>
              <input
                v-model="userInfo.phone"
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
                Email <span class="text-red-500">*</span>:
              </label>
              <input
                v-model="userInfo.email"
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
              <label class="block text-gray-700"> Description : </label>
              <textarea
                class="w-full h-[150px] border border-gray-300 p-2 rounded"
                v-model="userInfo.description"
                name="description"
                :class="{'border-red-500': errors.description}"
                id=""></textarea>
              <div class="h-5">
                <span v-if="errors.description" class="text-red-500 text-sm">{{
                  errors.description
                }}</span>
              </div>
            </div>
          </div>
          <div>
            <div class="mb-1">
              <label class="block text-gray-700"> MST : </label>
              <input
                v-model="userInfo.MST"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.MST}"
                type="text" />

              <div class="h-5">
                <span v-if="errors.MST" class="text-red-500 text-sm">{{
                  errors.MST
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Website : </label>
              <input
                v-model="userInfo.website"
                class="w-full border border-gray-300 p-2 rounded"
                :class="{'border-red-500': errors.website}"
                type="text" />
              <div class="h-5">
                <span v-if="errors.website" class="text-red-500 text-sm">{{
                  errors.website
                }}</span>
              </div>
            </div>
            <div class="mb-1">
              <label class="block text-gray-700"> Địa chỉ : </label>
              <input
                v-model="userInfo.address"
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
              <label class="block text-gray-700"> Trạng thái </label>
              <a-select
                ref="select"
                v-model:value="userInfo.status"
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
            <!-- <div class="mb-1">
                            <label class="block text-gray-700"> Avatar </label>
                            <input
                                ref="fileInput"
                                @change="handleAvatarChange"
                                class="hidden"
                                :class="{'border-red-500': errors.logo}"
                                type="file" />

                            <div class="flex justify-start gap-1">
                                <img
                                    v-if="!userInfo.logo"
                                    @click="triggerFileInput"
                                    src="@/assets/images/default.png"
                                    alt="Avatar preview"
                                    class="max-w-[150px] h-[150px] border rounded cursor-pointer"
                                    height="200"
                                    width="200" />

                                <img
                                    v-if="userInfo.logo"
                                    @click="triggerFileInput"
                                    :src="userInfo.logo"
                                    alt="Avatar preview"
                                    class="max-w-[150px] h-[150px] border rounded cursor-pointer"
                                    height="200"
                                    width="200" />
                            </div>
                            <div class="h-5">
                                <span v-if="errors.logo" class="text-red-500 text-sm">{{ errors.logo }}</span>
                            </div>
                        </div> -->
          </div>
          <div></div>
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
  import {ref, onMounted, watch} from 'vue';
  import {
    UserUpdateResType,
    UserUpdateRes,
  } from '@/schemaValidations/user.schema';
  import userRequestApi from '@/apiRequest/user';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import {handleErrorApi} from '@/lib/utils';
  import toastify from '@/components/ui/toast';
  import useForm from '@/lib/use-form';
  import {triggerFileInput} from '@/lib/utils';

  const props = defineProps<{
    modelValue: boolean;
    user: UserUpdateResType;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  const handleAvatarChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
      images.value = file;
      userInfo.value.logo = URL.createObjectURL(file);
    }
  };

  const {notifyError, notifySuccess} = toastify();

  const errors = ref<UserUpdateResType>({});

  const userInfo = ref<UserUpdateResType>({
    ...props.user,
  });

  const {setError, reset, validateForm} = useForm(
    UserUpdateRes,
    userInfo,
    errors
  );

  const images = ref<File>();
  const size = ref<SizeType>('large');
  const isSubmitting = ref(false);

  watch(
    () => props.user,
    () => {
      userInfo.value = props.user;
    }
  );

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  const handleSubmit = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      const result = await userRequestApi.update(userInfo.value);

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

  onMounted(() => {
    console.log('props user', props.user);
  });
</script>
