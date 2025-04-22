<template>
  <a-modal
    v-model:open="props.modelValue"
    @cancel="handleCancel"
    :footer="null"
    class="top-[30%] w-[400px] min-h-[500px] p-4">
    <div class="p-4 min-h-full">
      <div class="mx-auto bg-white rounded-lg min-h-full">
        <form
          class="flex flex-col justify-center min-h-full"
          @submit.prevent="handleSubmit">
          <div class="text-center mb-5">
            Bạn cần cập nhật đầy đủ thông tin để tiếp tục!
            <ExclamationCircleOutlined class="text-4xl text-orange-300" />
          </div>
          <div class="w-full flex justify-center">
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
                >Cập nhật</a-button
              >
            </a-space>
          </div>
        </form>
      </div>
    </div>
  </a-modal>
</template>

<script lang="ts" setup>
  import {ref} from 'vue';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import router from '@/router';
  import {ExclamationCircleOutlined} from '@ant-design/icons-vue';
  const props = defineProps<{
    modelValue: boolean;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  const size = ref<SizeType>('large');
  const isSubmitting = ref(false);

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  const handleSubmit = async () => {
    router.push({name: 'me'});
  };
</script>
