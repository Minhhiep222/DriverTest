<template>
  <a-modal
    :open="props.modelValue"
    title="Cài đặt chương trình"
    @cancel="handleCancel"
    :footer="null"
    class="min-w-full px-20">
    <div class="config-container w-full">
      <div class="scrollable-content">
        <div v-for="setting in data" :key="setting.id" class="day-config">
          <label class="day-label">
            <input
              type="checkbox"
              :checked="setting.status === 'Active'"
              @change="toggleStatus(setting)" />
            Ngày 0{{ setting.date }}/03/2025
          </label>
          <div class="time-range">
            <div class="time-label">Bắt đầu:</div>
            <input type="text" v-model="setting.start" placeholder="HH:mm" />
            <div class="time-label">Kết thúc:</div>
            <input type="text" v-model="setting.end" placeholder="HH:mm" />
          </div>
        </div>
      </div>
      <!-- <div class="user-limit">
        <div class="user-limit-label">Giới hạn trong một giờ:</div>
        <input type="number" placeholder="Số lượng" v-model="capab.quantity" />
      </div> -->
      <div class="bottom-section flex justify-end">
        <!-- <label class="active-label">
          <input
            type="checkbox"
            :checked="capab.status === 'Active'"
            @change="toggleStatus(capab)" />
          Kích hoạt
        </label> -->
        <button class="save-button" @click="handleSaveSetting">Lưu</button>
      </div>
    </div>
  </a-modal>
</template>

<script lang="ts" setup>
  import capabilitiesRequestApi from '@/apiRequest/capabilies';
  import settingRequestApi from '@/apiRequest/setting';
  import '@/assets/setting.css';
  import toastify from '@/components/ui/toast';
  import {handleErrorApi} from '@/lib/utils';
  import {CapabilitiesType} from '@/schemaValidations/capabilities.schema';
  import {SettingResType} from '@/schemaValidations/settings.schema';
  import Swal from 'sweetalert2';
  import {onMounted, ref} from 'vue';

  const {notifyError, notifySuccess} = toastify();
  const capab = ref<CapabilitiesType['data']>({
    quantity: 0,
    status: 'Inactive',
  });
  const data = ref<SettingResType['data']>([]);

  const props = defineProps<{
    modelValue: boolean;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
  };

  const handleSaveSetting = async () => {
    try {
      //Update settings and capabilities
      const settings = await settingRequestApi.update(data.value);

      const quantity = await capabilitiesRequestApi.update(capab.value);

      if (settings.status === 200 && quantity.status === 200) {
        Swal.fire({
          title: 'Thành công!',
          text: 'Cập nhật thành công',
          icon: 'success',
          confirmButtonText: 'OK',
        });
      } else {
        notifyError('Cập nhật thất bại');
      }
    } catch (error) {
      handleErrorApi(error);
    }
  };

  const handleGetSetting = async () => {
    try {
      const result = await settingRequestApi.setting();
      data.value = result.payload.data;
    } catch (error) {
      console.error('error', error);
    }
  };

  const handleGetCapabilities = async () => {
    try {
      const result = await capabilitiesRequestApi.capa();
      capab.value = result.payload.data;
    } catch (error) {
      console.error('Error fetching capabilities:', error);
    }
  };

  const toggleStatus = (setting: any) => {
    setting.status = setting.status === 'Active' ? 'Inactive' : 'Active';
  };

  onMounted(() => {
    handleGetSetting();
    handleGetCapabilities();
  });
</script>
