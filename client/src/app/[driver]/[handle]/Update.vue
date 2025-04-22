<template>
  <a-modal
    :open="props.modelValue"
    title="Thêm chương trình"
    @cancel="handleCancel"
    :footer="null"
    class="min-w-full top-[0px] bottom-[0] p-4">
    <form class="" @submit.prevent="onSubmit">
      <div class="form-group">
        <label class="block text-gray-700"> Hình ảnh: </label>
        <!-- Ẩn input file -->
        <input
          ref="fileInput"
          @change="handleAvatarChange"
          :class="{'border-red-500': errors.images}"
          class="hidden"
          type="file"
          id="createInput"
          multiple />

        <div class="flex justify-start gap-2">
          <!-- Hình ảnh mặc định -->
          <img
            v-if="images.length < 1"
            @click="triggerFileInput('createInput')"
            @error="handleImageError"
            src="@/assets/images/default.png"
            alt="Avatar preview"
            class="max-w-[150px] h-[150px] border rounded cursor-pointer"
            height="200"
            width="200" />

          <!-- Hình ảnh chọn từ file -->
          <div v-for="(image, index) in images" :key="index">
            <img
              @click="triggerFileInput('createInput')"
              :src="image"
              alt="Avatar preview"
              class="max-w-[150px] h-[150px] border-2 border-black rounded cursor-pointer"
              height="200"
              width="200" />
          </div>
        </div>
        <div class="h-5">
          <span v-if="errors.images" class="text-red-500 text-sm">{{
            errors.images
          }}</span>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
          <div class="form-group">
            <label for="name">Tên chương trình:</label>
            <input
              v-model="newProgram.name"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px]"
              :class="{'border-red-500': errors.name}"
              type="text" />

            <div class="h-5">
              <span v-if="errors.name" class="text-red-500 text-sm">{{
                errors.name
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="location">Địa chỉ:</label>
            <input
              v-model="newProgram.location"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px]"
              :class="{'border-red-500': errors.location}"
              type="text" />

            <div class="h-5">
              <span v-if="errors.location" class="text-red-500 text-sm">{{
                errors.location
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="contact">Liên hệ:</label>
            <input
              v-model="newProgram.contact"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px]"
              :class="{'border-red-500': errors.contact}" />
            <div class="h-5">
              <span v-if="errors.contact" class="text-red-500 text-sm">{{
                errors.contact
              }}</span>
            </div>
          </div>

          <div class="form-group mb-2">
            <div class="user-limit">
              <label class="user-limit-label"
                >Giới hạn người đăng ký trong một giờ:</label
              >
              <input
                type="number"
                class="max-w-[80px]"
                placeholder="Số lượng"
                :class="{'border-red-500': errors.quantity}"
                v-model="newProgram.quantity" />
              <div class="h-5">
                <span v-if="errors.quantity" class="text-red-500 text-sm">{{
                  errors.quantity
                }}</span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <!-- <div class="form-group">
            <div class="flex justify-between items-center">
              <label for="start_time">Thời gian bắt đầu:</label>
              <div
                class="underline cursor-pointer items-center flex gap-1 text-blue-600 text-xs"
                @click="showModal">
                Tùy chỉnh <SettingOutlined />
              </div>
            </div>
            <a-date-picker
              type="datetime-local"
              v-model="newProgram.start_time"
              @change="onDateChangeStarttime"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px]"
              :class="{'border-red-500': errors.start_time}" />

            <div class="h-5">
              <span v-if="errors.start_time" class="text-red-500 text-sm">{{
                errors.start_time
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <div class="flex justify-between items-center">
              <label for="end_time">Thời gian kết thúc:</label>
              <div
                class="underline cursor-pointer items-center flex gap-1 text-blue-600 text-xs"
                @click="showModal">
                Tùy chỉnh <SettingOutlined />
              </div>
            </div>
            <a-date-picker
              type="datetime-local"
              v-model="newProgram.end_time"
              @change="onDateChangeEndtime"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px]"
              :class="{'border-red-500': errors.end_time}" />
            <div class="h-5">
              <span v-if="errors.end_time" class="text-red-500 text-sm">{{
                errors.end_time
              }}</span>
            </div>
          </div> -->
          <div class="form-group">
            <div class="flex justify-between items-center">
              <label for="showroom">Hãng xe:</label>
              <div
                class="underline cursor-pointer items-center flex gap-1 text-blue-600 text-xs"
                @click="handleOpenCustomCarBrand">
                Tùy chỉnh <SettingOutlined />
                <CarbrandsModal
                  v-model:visible="visibleCarBrandsModal"
                  v-model:reloadSelect="reloadSelect" />
              </div>
            </div>
            <a-select
              v-model:value="newProgram.showroom"
              class="w-full"
              show-search
              :options="carBrands"
              :class="{'border-red-500': errors.showroom}">
            </a-select>

            <div class="h-5">
              <span v-if="errors.showroom" class="text-red-500 text-sm">{{
                errors.showroom
              }}</span>
            </div>
          </div>

          <div class="form-group">
            <div class="flex justify-between items-center">
              <label for="showroom">Màu xe:</label>
              <div
                class="underline cursor-pointer items-center flex gap-1 text-blue-600 text-xs"
                @click="handleOpenCustomColors">
                Tùy chỉnh <SettingOutlined />
                <ColorModal
                  v-model:visible="visibleColorsModal"
                  v-model:reloadSelect="reloadSelectColors" />
              </div>
            </div>
            <a-select
              ref="select"
              v-model:value="newProgram.color"
              style="width: 120px"
              show-search
              class="min-w-full rounded min-h-[45.6px]"
              :class="{'border-red-500': errors.color}"
              :options="colors">
            </a-select>
            <div class="h-5">
              <span v-if="errors.color" class="text-red-500 text-sm">{{
                errors.color
              }}</span>
            </div>
          </div>

          <!-- <div class="form-group">
            <div class="flex justify-between items-center">
              <label for="showroom">Dòng xe:</label>
              <div
                class="underline cursor-pointer items-center flex gap-1 text-blue-600 text-xs"
                @click="handleOpenCustomCars">
                Tùy chỉnh <SettingOutlined />
                <CarsModal
                  v-model:visible="visibleCarsModal"
                  v-model:reloadSelect="reloadSelectCars" />
              </div>
            </div>
            <a-select
              v-model:value="type"
              style="width: 100%"
              show-search
              mode="multiple"
              :class="{'border-red-500': errors.vehicle_type}"
              :options="cars"
              :onChange="handleChange"></a-select>
            <div class="h-5">
              <span v-if="errors.vehicle_type" class="text-red-500 text-sm">{{
                errors.vehicle_type
              }}</span>
            </div>
          </div> -->
          <div class="form-group">
            <label for="status">Trạng thái:</label>
            <a-select
              ref="select"
              v-model:value="newProgram.status"
              style="width: 120px"
              class="min-w-full rounded min-h-[45.6px]"
              :class="{'border-red-500': errors.status}">
              <a-select-option value="Active">Active</a-select-option>
              <a-select-option value="Inactive">Inactive</a-select-option>
            </a-select>
            <div class="h-5">
              <span v-if="errors.status" class="text-red-500 text-sm">{{
                errors.status
              }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="user-limit-label">Thời gian diễn ra:</label>
        <div class="scrollable-content">
          <div
            v-for="(setting, index) in data"
            :key="index"
            class="day-config grid grid-cols-2 gap-6">
            <a-date-picker
              type="date"
              @change="
                (date, dateString) => onDateChangeEndtime(dateString, index)
              "
              v-model:value="dateValues[index]"
              :class="{'border-red-500': errors.end_time}"
              class="w-full border border-gray-300 p-2 rounded h-[45.6px] max-w-[700px]" />

            <div class="time-range flex">
              <div class="flex items-center justify-center">
                <div class="time-label mr-2">Bắt đầu:</div>
                <input
                  class="min-w-[60px]"
                  type="time"
                  v-model="setting.start"
                  placeholder="HH:mm" />
              </div>

              <div class="flex items-center justify-center">
                <div class="time-label mr-2">Kết thúc:</div>
                <input
                  class="min-w-[60px]"
                  type="time"
                  v-model="setting.end"
                  placeholder="HH:mm" />
              </div>
              <div
                v-if="data.length > 1"
                class="flex items-center justify-center">
                <DeleteOutlined
                  @click="() => handleRemoveDate(index)"
                  class="text-xl cursor-pointer hover:text-red-500" />
              </div>
            </div>
          </div>
          <div class="h-5">
            <span v-if="errors.end_time" class="text-red-500 text-sm">{{
              errors.end_time
            }}</span>
          </div>
        </div>
        <div class="w-full flex justify-end">
          <a-button
            @click="handleAddDate"
            class="mt-2 border-none text-blue-500"
            type="default"
            >Thêm ngày</a-button
          >
        </div>
      </div>

      <div class="form-group">
        <label for="detailed">Mô tả chi tiết:</label>
        <textarea
          id="detailed"
          v-model="newProgram.description"
          :class="{'border-red-500': errors.description}"
          rows="4"></textarea>
        <div class="h-5">
          <span v-if="errors.description" class="text-red-500 text-sm">{{
            errors.description
          }}</span>
        </div>
      </div>
      <div class="w-full flex justify-end">
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
            >Lưu</a-button
          >
        </a-space>
      </div>
    </form>
  </a-modal>
</template>

<script lang="ts" setup>
  import apiCarBrands from '@/apiRequest/car-brands';
  import apiCars from '@/apiRequest/cars';
  import apiColors from '@/apiRequest/color';
  import driverRequestApi from '@/apiRequest/driver';
  import CarbrandsModal from '@/components/carbrands/carbrands.modal.vue';
  import CarsModal from '@/components/cars/cars.modal.vue';
  import ColorModal from '@/components/colors/colors.modal.vue';
  import toastify from '@/components/ui/toast';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import useForm from '@/lib/use-form';
  import {
    handleErrorApi,
    triggerFileInput,
    handleImageError,
  } from '@/lib/utils';
  import {
    DriverUpdateRes,
    DriverUpdateResType,
  } from '@/schemaValidations/driver.schema';
  import {SettingOutlined, DeleteOutlined} from '@ant-design/icons-vue';
  import {SelectProps} from 'ant-design-vue';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import {onMounted, ref, watch} from 'vue';
  import {SettingCreateResType} from '@/schemaValidations/settings.schema';
  import {CapabilitiesType} from '@/schemaValidations/capabilities.schema';
  import capabilitiesRequestApi from '@/apiRequest/capabilies';
  import settingRequestApi from '@/apiRequest/setting';
  import dayjs, {Dayjs} from 'dayjs';

  const size = ref<SizeType>('large');
  const isSubmitting = ref(false);
  const {notifyError, notifySuccess} = toastify();
  const carBrands = ref<SelectProps['options']>([]);
  const cars = ref<SelectProps['options']>([]);
  const colors = ref<SelectProps['options']>([]);
  const visibleCarBrandsModal = ref(false);
  const visibleCarsModal = ref(false);
  const visibleColorsModal = ref(false);
  const dateFormat = 'YYYY/MM/DD';

  const dateValues = ref<Dayjs[]>([]);

  const data = ref<SettingCreateResType>([
    {
      start: '08:00',
      end: '16:00',
      status: '',
      date: '2025-03-27',
    },
    {
      start: '08:00',
      end: '16:00',
      status: '',
      date: '2025-03-27',
    },
  ]);

  const capab = ref<CapabilitiesType['data']>({
    quantity: 0,
    status: 'Inactive',
  });

  const handleGetSetting = async () => {
    try {
      if (props.program) {
        const result = await settingRequestApi.setting(props.program.id);
        data.value = result.payload.data;
        dateValues.value = data.value.map((item) =>
          dayjs(item.date, 'YYYY-MM-DD')
        );
      }
    } catch (error) {
      console.error('error', error);
    }
  };

  const handleGetCapabilities = async () => {
    try {
      if (props.program) {
        const result = await capabilitiesRequestApi.capa(props.program.id);
        newProgram.value.quantity = result.payload.data.quantity;
      }
    } catch (error) {
      console.error('Error fetching capabilities:', error);
    }
  };

  const handleAddDate = () => {
    data.value.push({start: '08:00', end: '16:00', status: '', date: ''});
  };

  const handleRemoveDate = (index: number) => {
    data.value.splice(index, 1);
  };

  const onDateChangeEndtime = (dateString: string, index: number) => {
    const formattedDate = dayjs(dateString).format('YYYY-MM-DD');
    newProgram.value.end_time = formattedDate;
    data.value[index].date = formattedDate;
  };

  const handleOpenCustomCarBrand = () => {
    visibleCarBrandsModal.value = true;
  };
  const handleOpenCustomCars = () => {
    visibleCarsModal.value = true;
  };
  const handleOpenCustomColors = () => {
    visibleColorsModal.value = true;
  };
  const reloadSelect = async () => {
    const res = await apiCarBrands.getAll();
    carBrands.value = (res.payload as []).map(
      (brand: {id: number; name: string}) => ({
        value: brand.name,
        label: brand.name,
      })
    );
  };
  const reloadSelectCars = async () => {
    const res = await apiCars.getAll();
    cars.value = (res.payload as []).map(
      (brand: {id: number; name: string}) => ({
        value: brand.name,
        label: brand.name,
      })
    );
  };
  const reloadSelectColors = async () => {
    const res = await apiColors.getAll();
    colors.value = (res.payload as []).map(
      (color: {id: number; name: string}) => ({
        value: color.name,
        label: color.name,
      })
    );
  };
  const props = defineProps<{
    modelValue: boolean;
    program: DriverUpdateResType;
  }>();
  const newProgram = ref<DriverUpdateResType>({
    ...props.program,
  });

  const handleChange = (value: string | string[]) => {
    // Convert giá trị chọn thành kiểu string
    if (Array.isArray(value)) {
      newProgram.value.vehicle_type = value.join(', '); // Chuyển thành chuỗi nếu là mảng
    } else {
      newProgram.value.vehicle_type = value; // Nếu chỉ có 1 giá trị, đảm bảo kiểu string
    }
  };

  const errors = ref<DriverUpdateResType>({});
  const {setError, reset, validateForm} = useForm(
    DriverUpdateRes,
    newProgram,
    errors
  );

  const link = ref(LINK_TO_STORAGE);

  const images = ref<string[]>([]);

  const type = ref<string[]>([]);

  const handleAvatarChange = (event: Event) => {
    const files = (event.target as HTMLInputElement).files;
    if (files) {
      images.value = [];
      newProgram.value.images = [];
      Object.values(files).map((file) => {
        handleGetImage(URL.createObjectURL(file));
        newProgram.value.images.push(file);
      });
    }
  };

  const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    success: [];
  }>();

  const handleGetImage = (url: string) => {
    images.value.push(url);
  };

  const handleGetType = () => {
    const vehicle_type = props.program.vehicle_type.split(',');
    vehicle_type.map((item) => {
      type.value.push(item);
    });
  };
  watch(
    () => props.modelValue,
    (openedModal) => {
      if (openedModal && (!type.value || type.value.length === 0)) {
        handleGetType();
      }
    }
  );

  watch(
    () => props.program,
    () => {
      console.log('props.program', props.program);
      newProgram.value = props.program;
      handleGetSetting();
      handleGetCapabilities();
      if (props.program.vehicle_type) {
        handleGetType();
      }
      const files = props.program.images;
      if (files) {
        files.map((file) => {
          handleGetImage(link.value + file['path']);
        });
      }
    }
  );

  const onSubmit = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;
      const formData = new FormData();

      formData.append('name', newProgram.value.name);
      formData.append('color', newProgram.value.color);
      formData.append('showroom', newProgram.value.showroom);
      formData.append('location', newProgram.value.location);
      formData.append('vehicle_type', newProgram.value.vehicle_type);
      formData.append('start_time', newProgram.value.start_time);
      formData.append('end_time', newProgram.value.end_time);
      formData.append('contact', newProgram.value.contact);
      formData.append('status', newProgram.value.status);
      formData.append('description', newProgram.value.description);
      formData.append('settings', JSON.stringify(data.value));
      formData.append('quantity', newProgram.value.quantity.toString());
      formData.append('_method', 'PUT');

      // Nếu images là một mảng các tệp, bạn thêm từng tệp vào FormData
      if (Object.keys(images.value).length > 0) {
        newProgram.value.images.forEach((file, index) => {
          if (file instanceof File) {
            console.log(file, 'file');
            formData.append('img[]', file as Blob);
          } else {
          }
        });
      }

      const result = await driverRequestApi.update(
        formData as DriverUpdateResType,
        newProgram.value.id
      );

      notifySuccess(result.payload.message);
      // Reset form

      reset();

      handleReset();

      // Close modal/dialog
      emit('update:modelValue', false);

      // Emit success event để parent refresh data
      emit('success');
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
    } finally {
      isSubmitting.value = false; // Stop loading
    }
  };

  // Close modal
  const handleCancel = () => {
    emit('update:modelValue', false);
    handleReset();
  };

  const handleReset = () => {
    images.value = [];
    type.value = [];
  };

  onMounted(() => {
    reloadSelect();
    reloadSelectCars();
    reloadSelectColors();
  });
</script>

<style scoped>
  @import '../../../assets/program.css'; /* Đảm bảo đường dẫn đúng với cấu trúc thư mục của bạn */
</style>
