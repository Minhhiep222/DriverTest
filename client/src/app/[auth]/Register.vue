<template>
  <div class="register-container">
    <div class="register-header">
      <h2 class="register-title">Đăng ký</h2>
      <img src="@/img/baner-1.png" alt="Baner" width="1400" />
    </div>
    <form @submit.prevent="onSubmit">
      <div class="form-group">
        <!-- <button class="register-btn" onclick="submitRegister()">Register</button> -->
        <div class="mb-1 p-3">
          <a-input
            v-model:value.lazy="userInfo.phone"
            autofocus
            placeholder="Email..."
            :class="{'border-red-500': errors.phone}" />
          <div class="h-5">
            <span v-if="errors.phone" class="text-red-500 text-sm">
              {{ errors.phone }}
            </span>
          </div>
        </div>
        <div class="mb-1 p-3">
          <a-input-password
            v-model:value="userInfo.password"
            placeholder="Password"
            class="px-2"
            :class="{'border-red-500': errors.password}" />
          <div class="h-5">
            <span v-if="errors.password" class="text-red-500 text-sm">
              {{ errors.password }}
            </span>
          </div>
        </div>
        <a-button
          class="m-3"
          type="primary"
          :size="size"
          html-type="submit"
          :loading="isSubmitting"
          >Đăng ký</a-button
        >
        <div class="social-login">
          <a href="https://facebook.com" target="_blank" class="social-icon">
            <i class="fab fa-facebook-f">FB</i>
          </a>
          <a href="https://google.com" target="_blank" class="social-icon">
            <i class="fab fa-google">G</i>
          </a>
        </div>
      </div>
    </form>
    <!-- Footer register-->
    <div class="register-footer">
      Đã có tài khoản ?
      <li><router-link to="/login">Đăng nhập</router-link></li>
      <svg
        class="waves"
        xmlns="//www.w3.org/2000/svg"
        xmlns:xlink="//www.w3.org/1999/xlink"
        viewBox="0 24 150 28"
        preserveAspectRatio="none"
        shape-rendering="auto">
        <defs>
          <path
            id="gentle-wave"
            d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
          <use xlink:href="#gentle-wave" x="48" y="0" fill="#369BF8" />
          <use xlink:href="#gentle-wave" x="48" y="3" fill="#6DB9FF" />
          <use xlink:href="#gentle-wave" x="48" y="5" fill="#B7D6FF" />
        </g>
      </svg>
    </div>
  </div>
  <Verify v-model="showOtpModal" :register="userInfo" />
</template>
<script lang="ts" setup>
  import {ref, watch} from 'vue';
  import authRequestApi from '@/apiRequest/auth';
  import {
    RegisterBody,
    RegisterBodyType,
  } from '@/schemaValidations/auth.schema';
  import {handleErrorApi} from '@/lib/utils';
  import useForm from '@/lib/use-form';
  import toastify from '@/components/ui/toast';
  import Verify from './Verify.vue';
  import type {SizeType} from 'ant-design-vue/es/config-provider';

  const isSubmitting = ref(false);
  const showOtpModal = ref(false);
  const size = ref<SizeType>('large');
  const errors = ref<RegisterBodyType>({});
  const {notifyError, notifySuccess} = toastify();
  const userInfo = ref<RegisterBodyType>({
    phone: '',
  });
  const {setError, reset, validateForm} = useForm(
    RegisterBody,
    userInfo,
    errors
  );
  const onSubmit = async () => {
    isSubmitting.value = true;
    try {
      if (!validateForm()) {
        return;
      }
      const result = await authRequestApi.register(userInfo.value);
      if (result && result.payload && result.status === 200) {
        notifySuccess(result.payload.message);
        showOtpModal.value = true;
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
    } finally {
      isSubmitting.value = false;
    }
  };
</script>

<style scoped>
  @import '../../assets/register.css';
</style>
