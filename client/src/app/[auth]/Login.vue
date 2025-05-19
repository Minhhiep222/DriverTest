<template>
  <div class="login-container">
    <div class="login-header">
      <h2 class="login-title">Đăng Nhập</h2>
      <img src="@/img/baner-1.png" alt="Baner" width="1400" />
    </div>
    <div class="login-form-container">
      <form @submit.prevent="login">
        <div class="form-group">
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
            >Đăng nhập</a-button
          >
        </div>
        <!-- Đăng nhập qua mạng xã hội -->
        <div class="social-login">
          <a href="https://facebook.com" target="_blank" class="social-icon">
            <i class="fab fa-facebook-f">FB</i>
          </a>
          <a href="https://google.com" target="_blank" class="social-icon">
            <i class="fab fa-google">G</i>
          </a>
        </div>
      </form>
    </div>
    <transition v-if="showForgotPassword || showVerifyOtp" name="fade">
      <div class="forgot-password-container">
        <div v-if="showForgotPassword" class="p-2">
          <div class="forgot-password-header">
            <h2>Quên Mật Khẩu</h2>
            <p>Nhập Email của bạn để nhận liên kết đặt lại mật khẩu.</p>
          </div>
          <div class="forgot-password-form">
            <form @submit.prevent="handleForgotPassword">
              <div class="form-group">
                <div class="mb-1 p-3">
                  <input
                    v-model="username.phone"
                    name=""
                    placeholder="Email..."
                    required
                    class="input-field"
                    :class="{'border-red-500': errorsForgot.phone}" />
                  <div class="h-5">
                    <span
                      v-if="errorsForgot.phone"
                      class="text-red-500 text-sm">
                      {{ errorsForgot.phone }}
                    </span>
                  </div>
                </div>
                <a-button
                  class="m-3"
                  type="primary"
                  :size="size"
                  html-type="submit"
                  :loading="isSubmitting"
                  >Gửi</a-button
                >
              </div>
            </form>
          </div>
          <div class="forgot-password-footer">
            <a @click="showForgotPassword = false">Hủy</a>
          </div>
        </div>
        <div v-if="showVerifyOtp" class="p-2">
          <div class="forgot-password-header">
            <h2>Xác nhận</h2>
            <p>Nhập mã OTP vừa được gửi qua.</p>
          </div>
          <div class="forgot-password-form">
            <form @submit.prevent="onSubmitVerifyOtp">
              <div class="form-group">
                <div class="mb-1 p-3">
                  <input
                    name=""
                    v-model="otpVerify.otp"
                    placeholder="OTP..."
                    required
                    class="input-field"
                    :class="{'border-red-500': errorsVerify.otp}" />
                  <div class="h-5">
                    <span v-if="errorsVerify.otp" class="text-red-500 text-sm">
                      {{ errorsVerify.otp }}
                    </span>
                  </div>
                </div>
              </div>
              <a-button
                class="m-3"
                type="primary"
                :size="size"
                html-type="submit"
                :loading="isSubmitting"
                >Xác nhận</a-button
              >
            </form>
          </div>
          <div class="forgot-password-footer">
            <a @click="showForgotPassword = false">Hủy</a>
          </div>
        </div>
      </div>
    </transition>
    <div class="login-footer">
      Chưa có tài khoản ? <router-link to="/register">Đăng ký</router-link>
      <br />
      Không thể đăng nhập ? <a @click="toggleForgotPassword">Quên mật khẩu</a>
      <svg
        class="waves"
        xmlns="http://www.w3.org/2000/svg"
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
</template>

<script lang="ts" setup>
  import {useStore} from 'vuex';
  import authRequest from '@/apiRequest/auth';
  import {ref} from 'vue';
  import {useRouter} from 'vue-router';
  import {
    LoginBodyRes,
    LoginBodyResType,
    ForgotBodyResType,
    VerifyOTPResType,
  } from '@/schemaValidations/auth.schema';
  import {handleErrorApi} from '@/lib/utils';
  import useForm from '@/lib/use-form';
  import toastify from '@/components/ui/toast';
  import type {SizeType} from 'ant-design-vue/es/config-provider';

  const isSubmitting = ref(false);
  const size = ref<SizeType>('large');
  const store = useStore();
  const router = useRouter();
  const errors = ref<LoginBodyResType>({});
  const errorsForgot = ref<ForgotBodyResType>({});
  const errorsVerify = ref<VerifyOTPResType>({});
  const {notifyError, notifySuccess} = toastify();

  const userInfo = ref<LoginBodyResType>({});
  const {setError, reset, validateForm} = useForm(
    LoginBodyRes,
    userInfo,
    errors
  );
  const showForgotPassword = ref(false);
  const showVerifyOtp = ref(false);
  const username = ref<ForgotBodyResType>({phone: ''});
  const otpVerify = ref<VerifyOTPResType>({otp: ''});

  const toggleForgotPassword = () => {
    showForgotPassword.value = true;
  };

  const onSubmitVerifyOtp = async () => {
    isSubmitting.value = true;
    try {
      otpVerify.value.phone = username.value.phone;

      if (!otpVerify.value.otp) {
        errorsVerify.value.otp = 'Vui lòng nhập mã OTP';
        return;
      }

      const result = await authRequest.verifyOTP(otpVerify.value);

      if (result.status === 200) {
        showVerifyOtp.value = false;
        showForgotPassword.value = false;
        location.href = '/login';
        notifySuccess('Đổi mật khẩu thành công!');
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Mã OTP không đúng');
    } finally {
      isSubmitting.value = false;
    }
  };

  const handleForgotPassword = async () => {
    showForgotPassword.value = true;
    isSubmitting.value = true;
    try {
      if (!username.value.phone) {
        errorsForgot.value.phone = 'Vui lòng nhập số điện thoại';
        return;
      }

      const result = await authRequest.fogot(username.value);
      if (result.status === 200) {
        notifySuccess('Mã OTP đã được gửi đến điện thoại của bạn');
        showVerifyOtp.value = true;
        showForgotPassword.value = false;
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Tên đăng nhập không tồn tại trong hệ thống');
    } finally {
      isSubmitting.value = false;
    }
  };

  const login = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      const response = await authRequest.login(userInfo.value);

      if (response && response.payload && response.status === 200) {
        store.dispatch('login', response.payload.data.account);
        if (response.payload.data.account.role === 'user') {
          router.push('/drive-management');
        } else if (response.payload.data.account.role === 'admin') {
          router.push('/admin');
        }
        notifySuccess(response.payload.message);
        reset();
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
    } finally {
      isSubmitting.value = false;
    }
  };
</script>

<style>
  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-group input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
    box-sizing: border-box;
  }

  .form-group input:focus {
    border-color: #6dc1ff;
  }
  .submit-btn {
    display: block;
    width: 100%;
    padding: 10px;
    background: #369bf8;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .submit-btn:hover {
    background: #2c8ae6;
  }

  /* Container chính */
  .login-container {
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    font-family: Arial, sans-serif;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .login-container:hover {
    transform: scale(1.02);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
  }

  /* Header */
  .login-header {
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
  }

  /* Tiêu đề */
  .login-title {
    position: absolute;
    bottom: 40px;
    left: 20px;
    text-align: center;
    font-size: 48px;
    color: #ffffff;
    font-weight: bold;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  }

  /* Đăng nhập qua mạng xã hội */
  .social-login {
    text-align: center;
    margin: 20px 0;
  }

  .social-login a {
    margin: 0 15px;
    font-size: 24px;
    color: #6dc1ff;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .social-login a:hover {
    color: #4aa0ff;
  }

  /* Footer */
  .login-footer {
    text-align: center;
    font-size: 14px;
    margin-bottom: 20px;
  }

  .login-footer a {
    color: #6dc1ff;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
  }

  .login-footer a:hover {
    text-decoration: underline;
  }

  /* Waves Animation */
  .waves {
    position: relative;
    width: 100%;
    height: 15vh;
    margin-bottom: -7px;
    min-height: 100px;
    max-height: 150px;
  }

  .parallax > use {
    animation: move-forever 25s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
  }

  .parallax > use:nth-child(1) {
    animation-delay: -2s;
    animation-duration: 7s;
  }

  .parallax > use:nth-child(2) {
    animation-delay: -3s;
    animation-duration: 10s;
  }

  .parallax > use:nth-child(3) {
    animation-delay: -4s;
    animation-duration: 13s;
  }

  @keyframes move-forever {
    0% {
      transform: translate3d(-90px, 0, 0);
    }

    100% {
      transform: translate3d(85px, 0, 0);
    }
  }

  /* Mobile responsive wave */
  @media (max-width: 768px) {
    .waves {
      height: 40px;
      min-height: 40px;
    }
  }

  /* Forget password styles */
  .forgot-password-container {
    max-width: 400px;
    margin: 150px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  .forgot-password-header h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
  }

  .forgot-password-header p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
  }

  .forgot-password-form .form-group {
    margin-bottom: 20px;
  }

  .forgot-password-footer {
    margin-top: 20px;
  }

  .forgot-password-footer a {
    color: #369bf8;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
  }

  .forgot-password-footer a:hover {
    text-decoration: underline;
  }

  /* Transition for fade */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
</style>
