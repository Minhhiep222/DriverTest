<template>
    <a-modal
        v-model:open="props.modelValue"
        title="Chi tiết thông tin lái xe"
        @cancel="handleCancel"
        :footer="null"
        class="min-w-full top-[0px] bottom-[0] p-4">
        <div class="p-4">
            <div class="mx-auto bg-white rounded-lg">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="mb-1">
                            <label class="text-gray-700">Tên Lái Xe:</label>
                            <p class="w-full p-2">{{ program?.name || 'Không có dữ liệu' }}</p>
                        </div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Loại Xe:</label>
                            <p class="w-full p-2">{{ program?.vehicle_type || 'Không có dữ liệu' }}</p>
                        </div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Trạng thái:</label>
                            <p class="w-full p-2">{{ program?.status || 'Không có dữ liệu' }}</p>
                        </div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Liên hệ:</label>
                            <p class="w-full p-2">{{ program?.contact || 'Không có dữ liệu' }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Mô Tả:</label>
                            <p class="w-full p-2">{{ program?.description || 'Không có dữ liệu' }}</p>
                        </div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Ngày bắt đầu:</label>
                            <p class="w-full p-2">{{ program?.start_time || 'Không có dữ liệu' }}</p>
                        </div>
                        <div class="mb-1">
                            <label class="block text-gray-700">Ngày kết thúc:</label>
                            <p class="w-full p-2">{{ program?.end_time || 'Không có dữ liệu' }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end mt-4">
                    <a-button type="default" size="default" @click="handleCancel">Đóng</a-button>
                    <a-button type="default" size="default" @click="showModal">Đăng ký lái thử</a-button>
                </div>
            </div>
        </div>
    </a-modal>
    <Create v-model="open" @success="" />
</template>

<script lang="ts" setup>
import { onMounted, ref, watch } from 'vue';
import { defineProps, defineEmits } from 'vue';
import { DriverReadResType } from '@/schemaValidations/driver.schema';
import logbookRequestApi from '@/apiRequest/logbook';
//import Create from './FormDangKyLT.vue';
import { LogBookCreateRes } from '@/schemaValidations/logbook.schema';
const open = ref<boolean>(false);
const showModal = () => {
  open.value = true;
};


//log danh sách
const props = defineProps<{
    modelValue: boolean;
    program: DriverReadResType['data'];
}>();

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
}>();

// Hàm đóng modal
const handleCancel = () => {
    emit('update:modelValue', false); // Đóng modal
};
</script>
