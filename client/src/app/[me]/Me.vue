<template>
  <div class="container mx-auto p-6">
    <div class="bg-white p-6 shadow-lg rounded-xl">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">🏠 Hồ sơ Showroom</h2>
      <div class="mb-1">
        <label class="block text-gray-700"> Avatar </label>
        <input
          id="imgInput"
          ref="fileInput"
          @change="handleAvatarChange"
          class="hidden"
          :class="{'border-red-500': errors.logo}"
          type="file" />

        <div class="flex justify-start gap-1">
          <img
            v-if="!userInfo.logo"
            @click="() => triggerFileInput('imgInput')"
            src="@/assets/images/default.png"
            alt="Avatar preview"
            class="max-w-[150px] h-[150px] border rounded cursor-pointer"
            height="200"
            width="200" />

          <img
            v-if="userInfo.logo"
            @click="() => triggerFileInput('imgInput')"
            :src="userInfo.logo"
            alt="Avatar preview"
            class="max-w-[150px] h-[150px] border rounded cursor-pointer"
            height="200"
            width="200" />
        </div>
        <div class="h-5">
          <span v-if="errors.logo" class="text-red-500 text-sm">{{
            errors.logo
          }}</span>
        </div>
      </div>
      <!-- Thông tin cá nhân -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-gray-700 font-medium">Tên Showroom</label>
          <input
            type="text"
            v-model="userInfo.fullname"
            class="input-field"
            :class="{'border-red-500': errors.fullname}"
            placeholder="Nhập tên showroom" />
          <span v-if="errors.fullname" class="text-red-500 text-sm">
            {{ errors.fullname }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium">Tên rút gọn</label>
          <input
            type="text"
            v-model="userInfo.shortname"
            class="input-field"
            :class="{'border-red-500': errors.shortname}"
            placeholder="Nhập tên showroom" />
          <span v-if="errors.shortname" class="text-red-500 text-sm">
            {{ errors.shortname }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium">Địa chỉ</label>
          <input
            type="text"
            v-model="userInfo.address"
            class="input-field"
            :class="{'border-red-500': errors.address}"
            placeholder="Nhập địa chỉ" />
          <span v-if="errors.address" class="text-red-500 text-sm">
            {{ errors.address }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium">Số điện thoại</label>
          <input
            type="text"
            v-model="userInfo.phone"
            class="input-field"
            :class="{'border-red-500': errors.phone}"
            placeholder="Nhập số điện thoại" />
          <span v-if="errors.phone" class="text-red-500 text-sm">
            {{ errors.phone }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium">Email</label>
          <input
            type="email"
            v-model="userInfo.email"
            class="input-field"
            :class="{'border-red-500': errors.email}"
            placeholder="Nhập email" />
          <span v-if="errors.email" class="text-red-500 text-sm">
            {{ errors.email }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium"
            >Thông tin về doanh nghiệp (Trang web)</label
          >
          <input
            type="text"
            v-model="userInfo.website"
            class="input-field"
            :class="{'border-red-500': errors.website}"
            placeholder="Nhập website" />
          <span v-if="errors.website" class="text-red-500 text-sm">
            {{ errors.website }}
          </span>
        </div>
        <div>
          <label class="block text-gray-700 font-medium">Mã số thuế</label>
          <input
            type="text"
            v-model="userInfo.MST"
            class="input-field"
            :class="{'border-red-500': errors.MST}"
            placeholder="Nhập mã số thuế" />
          <span v-if="errors.MST" class="text-red-500 text-sm">
            {{ errors.MST }}
          </span>
        </div>
      </div>

      <!-- Mô tả showroom -->
      <div class="mt-6">
        <label class="block text-gray-700 font-medium">Mô tả showroom</label>
        <textarea
          v-model="userInfo.description"
          class="input-field h-32"
          placeholder="Mô tả chi tiết về showroom..."></textarea>
      </div>

      <!-- Nút lưu -->
      <div class="flex justify-end mt-6">
        <a-button
          type="primary"
          :size="size"
          html-type="submit"
          :loading="isSubmitting"
          @click="handleSubmit"
          >Lưu</a-button
        >
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import {onMounted, ref} from 'vue';
  import authRequestApi from '@/apiRequest/auth';
  import {MeUpdateBodyResType} from '@/schemaValidations/auth.schema';
  import {
    UserUpdateResType,
    UserUpdateRes,
  } from '@/schemaValidations/user.schema';
  import toastify from '@/components/ui/toast';
  import useForm from '@/lib/use-form';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import {handleErrorApi} from '@/lib/utils';
  import {triggerFileInput} from '@/lib/utils';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import router from '@/router';
  import {useStore} from 'vuex';

  const {notifyError, notifySuccess} = toastify();
  const errors = ref<UserUpdateResType>({});
  const images = ref<File | string>();
  const size = ref<SizeType>('large');
  const store = useStore();
  const isSubmitting = ref(false);
  const userInfo = ref<UserUpdateResType>({
    status: 'Active',
  });

  const {setError, reset, validateForm} = useForm(
    UserUpdateRes,
    userInfo,
    errors
  );

  const handleAvatarChange = (event: Event) => {
    const files = (event.target as HTMLInputElement).files[0];
    if (files) {
      images.value = files;
      userInfo.value.logo = URL.createObjectURL(files);
    }
  };

  const me = async () => {
    const res = await authRequestApi.me();
    if (res.payload.data.details) {
      userInfo.value = res.payload.data.details;
      userInfo.value.logo = `${LINK_TO_STORAGE}${res.payload.data.details.logo}`;
    }
  };

  const handleSubmit = async () => {
    try {
      userInfo.value.status = 'Active';
      if (!validateForm()) {
        return;
      }
      isSubmitting.value = true;

      const formData = new FormData();

      formData.append('fullname', userInfo.value.fullname);
      formData.append('address', userInfo.value.address);
      formData.append('email', userInfo.value.email);
      formData.append('phone', userInfo.value.phone);
      formData.append('shortname', userInfo.value.shortname);
      formData.append('status', userInfo.value.status);
      if (userInfo.value.MST !== null) {
        formData.append('MST', userInfo.value.MST);
      }
      if (userInfo.value.website !== null) {
        formData.append('website', userInfo.value.website);
      }
      if (userInfo.value.description !== null) {
        formData.append('description', userInfo.value.description);
      }

      formData.append('_method', 'PUT');

      // Nếu images là một mảng các tệp, bạn thêm từng tệp vào FormData
      if (images.value !== null) {
        formData.append('image', images.value as Blob);
      }

      const res = await authRequestApi.update(formData as MeUpdateBodyResType);
      const state = {
        name: res.payload.data.name,
      };
      store.dispatch('login', res.payload.data);

      notifySuccess(res.payload.message);
      // Reset form

      images.value = null;

      localStorage.removeItem('verify');

      setTimeout(() => {
        router.go(-1);
      }, 2000);
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
    me();
  });
</script>

<style>
  .input-field {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
  }

  .input-field:focus {
    outline: none;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
    border-color: #3333;
  }

  .btn-save {
    background-color: #f59e0b;
    color: #fff;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    transition: background-color 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: none;
    cursor: pointer;
  }

  .btn-save:hover {
    background-color: #d97706;
  }
</style>
