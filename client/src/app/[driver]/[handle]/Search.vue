<template>
  <div class="global-search-wrapper" style="width: 300px">
    <a-auto-complete
      v-model:value="key"
      :dropdown-match-select-width="252"
      style="width: 300px"
      :options="data"
      @select="onSelect"
      :open="isOpen"
      class="min-h-[40px]"
      @search="handleSearch">
      <template #option="data">
        <div style="display: flex; justify-content: space-between">
          <span>
            <a rel="noopener noreferrer">
              {{ data.value }}
            </a>
          </span>
          <span>{{ data.count }} results</span>
        </div>
      </template>
      <a-input-search
        size="large"
        placeholder="Search"
        class="min-h-[40px]"
        @search="onSearch" />
    </a-auto-complete>
  </div>
</template>

<script lang="ts" setup>
  import logbookRequestApi from '@/apiRequest/logbook';

  import {ref} from 'vue';

  const key = ref<string>('');
  const isOpen = ref(false);

  defineProps<{
    modelValue: string;
  }>();

  const emit = defineEmits<{
    'update:modelValue': [value: string];
    success: [];
  }>();

  interface Option {
    query: string;
    category: string;
    value: string;
    count: number;
  }

  const data = ref<Option[]>([]);

  const onSelect = (value: string) => {
    isOpen.value = false;
    emit('update:modelValue', value);
  };

  const onSearch = (value: string) => {
    isOpen.value = true;
    handleSearch(value);
  };

  // Hàm tìm kiếm từ API
  const searchResult = async (query: string) => {
    const body = {key: query, page: 1, per_page: 10};
    const result = await logbookRequestApi.search(body);
    const data = result.payload.data.map((item: any) => ({
      query,
      category: `${query}`,
      value: `${item.fullname}`,
      count: result.payload.totalRecord,
    }));

    return data;
  };

  const handleSearch = async (val: string) => {
    isOpen.value = true; // Mở dropdown
    data.value = await searchResult(val);
    emit('update:modelValue', val);
  };
</script>
