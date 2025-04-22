<template>
  <a-modal
    v-model:open="props.modelValue"
    :footer="null"
    class="top-[30%] w-[400px] min-h-[500px] p-4">
    <div class="text-center">
      Mã mà OTP vừa gửi đến số điện thoại <b>{{ register.phone }}</b> của quý
      khách. vui lòng nhập mã OTP và ô dưới đây để hoàn tất
    </div>
    <div class="input-group-otp">
      <label for="otp">Vui lòng nhập mã OTP</label>
      <div class="mb-1 p-3">
        <a-input
          v-model:value.lazy="verify.otp"
          autofocus
          placeholder="Nhập mã OTP..."
          :class="{'border-red-500': errors.otp}" />
        <div class="h-5">
          <span v-if="errors.otp" class="text-red-500 text-sm">
            {{ errors.otp }}
          </span>
        </div>
      </div>
    </div>
    <div class="otp-resend" @click="handleResend">
      <a href="#">Gửi lại mã OTP</a>
    </div>
    <div class="w-full flex justify-center">
      <a-space>
        <a-button
          danger
          class="min-w-[50px]"
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
          @click="verifyOtp"
          >Login</a-button
        >
      </a-space>
    </div>
  </a-modal>
</template>

<script lang="ts" setup>
  import {ref, watch} from 'vue';
  import {
    VerifyBodyRes,
    VerifyBodyResType,
    RegisterBodyType,
  } from '@/schemaValidations/auth.schema';
  import {useRouter} from 'vue-router';
  import authRequestApi from '@/apiRequest/auth';
  import {handleErrorApi} from '@/lib/utils';
  import useForm from '@/lib/use-form';
  import toastify from '@/components/ui/toast';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import {useStore} from 'vuex';

  const store = useStore();
  const router = useRouter();
  const verify = ref<VerifyBodyResType>({});
  const errors = ref<VerifyBodyResType>({});
  const {notifyError, notifySuccess} = toastify();
  const {setError, reset, validateForm} = useForm(
    VerifyBodyRes,
    verify,
    errors
  );
  const size = ref<SizeType>('large');
  const isSubmitting = ref(false);

  const props = defineProps<{
    modelValue: boolean;
    register: RegisterBodyType;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  watch(
    () => props.register,
    () => {
      verify.value.phone = props.register.phone;
      verify.value.password = props.register.password;
    },
    {deep: true}
  );

  const verifyOtp = async () => {
    try {
      if (!validateForm()) {
        return;
      }
      verify.value.phone = props.register.phone;
      verify.value.password = props.register.password;
      isSubmitting.value = true;
      const result = await authRequestApi.verify(verify.value);
      if (result && result.payload && result.status === 200) {
        store.dispatch('login', result.payload.data.account);
        if (result.payload.data.account.role === 'user') {
          router.push('/drive-management');
          localStorage.setItem(
            'verify',
            JSON.stringify(result.payload.data.account)
          );
        } else if (result.payload.data.account.role === 'admin') {
          router.push('/admin');
        }
        notifySuccess('Đăng ký thành công');
        reset();
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

  const handleResend = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      verify.value = props.register;

      const result = await authRequestApi.resend(verify.value);

      if (result && result.payload && result.status === 200) {
        notifySuccess(result.payload.message);
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
    }
  };
</script>
