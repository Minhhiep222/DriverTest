<template>
    <a-modal
        v-model:open="props.modelValue"
        @cancel="handleCancel"
        :footer="null"
        class="top-[30%] w-[400px] min-h-[500px] p-4">
        <div class="p-4 min-h-full">
            <div class="mx-auto bg-white rounded-lg min-h-full">
                <form class="flex flex-col justify-center min-h-full" @submit.prevent="handleSubmit">
                    <div class="text-center mb-5">
                        Bạn có chắc là xóa người dùng <span class="font-bold">{{ props.user.fullname }} </span> không?
                    </div>
                    <div class="w-full flex justify-center">
                        <a-space>
                            <a-button type="default" :size="size" @click="handleCancel" :loading="isSubmitting"
                                >Hủy</a-button
                            >
                            <a-button danger type="primary" :size="size" html-type="submit" :loading="isSubmitting"
                                >Xóa</a-button
                            >
                        </a-space>
                    </div>
                </form>
            </div>
        </div>
    </a-modal>
</template>

<script lang="ts" setup>
    import {ref, onMounted, watch} from 'vue';
    import {UserDeleteResType} from '@/schemaValidations/user.schema';
    import userRequestApi from '@/apiRequest/user';
    import type {SizeType} from 'ant-design-vue/es/config-provider';
    import {handleErrorApi} from '@/lib/utils';
    import toastify from '@/components/ui/toast';

    const props = defineProps<{
        modelValue: boolean;
        user: UserDeleteResType;
    }>();

    const emit = defineEmits<{
        'update:modelValue': [value: boolean];
        success: [];
    }>();

    const {notifyError, notifySuccess} = toastify();

    const userInfo = ref<UserDeleteResType>({});

    const size = ref<SizeType>('large');
    const isSubmitting = ref(false);

    watch(
        () => props.user,
        () => {
            userInfo.value = props.user;
        },
        {deep: true}
    );

    // Close modal
    const handleCancel = () => {
        emit('update:modelValue', false);
    };

    const handleSubmit = async () => {
        try {
            isSubmitting.value = true;

            const result = await userRequestApi.delete(props.user);

            notifySuccess(result.payload.message);

            // Close modal/dialog
            emit('update:modelValue', false);

            // Emit success event để parent refresh data
            emit('success');
        } catch (error) {
            handleErrorApi({
                error,
            });
            notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
        } finally {
            isSubmitting.value = false; // Stop loading
        }
    };

    onMounted(() => {});
</script>
