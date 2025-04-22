<template></template>

<script lang="ts" setup>
  import capabilitiesRequestApi from '@/apiRequest/capabilies';
  import settingRequestApi from '@/apiRequest/setting';
  import '@/assets/setting.css';
  import {CapabilitiesType} from '@/schemaValidations/capabilities.schema';
  import {SettingResType} from '@/schemaValidations/settings.schema';
  import {onMounted, ref} from 'vue';

  const capab = ref<CapabilitiesType['data']>({
    quantity: 0,
    status: 'Inactive',
  });
  const data = ref<SettingResType['data']>([]);

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
