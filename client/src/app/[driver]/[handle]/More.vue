<template>
  <div class="flex justify-center mt-4">
    <div class="related-programs">
      <h3 class="related-title">Các Chương Trình Lái Thử Khác</h3>
      <div class="programs-list">
        <div
          class="program-item"
          v-for="program in programs?.slice(0, 3)"
          :key="program.id">
          <h4 class="program-name">{{ program.name }}</h4>
          <p class="program-showroom">Showroom: {{ program.showroom }}</p>
          <p class="program-date">
            Thời gian: {{ formatDate(program.start_time) }} -
            {{ formatDate(program.end_time) }}
          </p>
          <button class="program-button" @click="handDetail(program)">
            Xem chi tiết
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import {onMounted, ref} from 'vue';
  import {useRouter} from 'vue-router';
  import driverRequestApi from '@/apiRequest/driver';
  import {DriverResType} from '@/schemaValidations/driver.schema';
  const key = ref<string>('');
  const programs = ref<DriverResType['data']>([]);
  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const router = useRouter();

  //chuyển qua chi tiết
  const handDetail = (program) => {
    router.push(`/${program.id}/detail`);
    location.href = `/${program.id}/detail`;
  };

  const formatDate = (dateString: string): string => {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };

  const handleGetDriver = async () => {
    try {
      const body = {page: page.value, per_page: per_page.value, key: key.value};
      const result = await driverRequestApi.program(body);
      programs.value = result.payload.data;
      totalRecord.value = result.payload.totalRecord;
    } catch (error) {
      console.error('error', error);
    }
  };

  onMounted(() => {
    handleGetDriver();
  });
</script>
