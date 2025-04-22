<template>
  <div class="contener">
    <div class="booking-container">
      <h2>ĐẶT LỊCH GIỮ CHỖ</h2>
      <h3>Lái Thử</h3>

      <div class="step-container">
        <form @submit.prevent="onSubmit">
          <div class="form-group">
            <label for="ten">Tên <span class="required">*</span></label>
            <input
              type="text"
              id="ten"
              placeholder="Ví dụ: Nguyễn Văn A"
              v-model="formData.fullname"
              :class="{'border-red-500': errors.fullname}"
              required />
            <div class="h-5">
              <span v-if="errors.fullname" class="text-red-500 text-sm">{{
                errors.fullname
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="sdt"
              >Số Điện Thoại <span class="required">*</span></label
            >
            <input
              type="tel"
              id="sdt"
              placeholder="Ví dụ: 0901234567"
              v-model="formData.phone"
              :class="{'border-red-500': errors.phone}"
              required />
            <div class="h-5">
              <span v-if="errors.phone" class="text-red-500 text-sm">{{
                errors.phone
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="ghichu">Ghi Chú</label>
            <textarea
              id="ghichu"
              placeholder="Yêu cầu đặc biệt, loại xe quan tâm,..."
              v-model="formData.description"
              :class="{'border-red-500': errors.description}"></textarea>
            <div class="h-5">
              <span v-if="errors.description" class="text-red-500 text-sm">{{
                errors.description
              }}</span>
            </div>
          </div>
          <div class="form-group mb-0">
            <label for="thoigian"
              >Thời Gian Lái (Dự Kiến) <span class="required">*</span></label
            >
            <a-radio-group
              button-style="solid"
              v-model:value="formData.date_drive"
              @change="onDateChange"
              :class="{'border-red-500': formData.date_drive}"
              class="flex justify-center gap-2 flex-wrap">
              <a-radio-button
                :value="`${date.getFullYear()}-${String(
                  date.getDate()
                ).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(
                  2,
                  '0'
                )}`"
                :disabled="stripTime(date) < stripTime(new Date())"
                v-for="date in rangeDate.date">
                {{ formatDate(date) }}
              </a-radio-button>
            </a-radio-group>
          </div>
          <div class="h-5">
            <span v-if="errors.date_drive" class="text-red-500 text-sm">{{
              errors.date_drive
            }}</span>
          </div>
          <div class="time-slots mt-0" v-if="formData.date_drive">
            <a-button
              v-for="time in filteredTimeSlots"
              :key="time"
              :size="size"
              :class="{
                selected: time === formData.time_drive,
                disabled: isTimeDisabled(time),
                'border-red-500': errors.time_drive,
              }"
              :disabled="isTimeDisabled(time)"
              @click.prevent="selectTime(time)">
              {{ time }}
            </a-button>
            <div class="h-5">
              <span v-if="errors.time_drive" class="text-red-500 text-sm">{{
                errors.time_drive
              }}</span>
            </div>
          </div>
          <a-space class="flex justify-center">
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
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import capasRequestApi from '@/apiRequest/capabilies';
  import driverRequestApi from '@/apiRequest/driver';
  import booksRequestApi from '@/apiRequest/logbook';
  import settingsRequestApi from '@/apiRequest/setting';
  import toastify from '@/components/ui/toast';
  import useForm from '@/lib/use-form';
  import {formatDate, handleErrorApi} from '@/lib/utils';
  import {DriverReadResType} from '@/schemaValidations/driver.schema';
  import {
    LogBookBodyRes,
    LogBookCreateResType,
  } from '@/schemaValidations/logbook.schema';
  import {SettingResType} from '@/schemaValidations/setting.schema';
  import type {SizeType} from 'ant-design-vue/es/config-provider';
  import Swal from 'sweetalert2';
  import {computed, onMounted, ref, watch} from 'vue';
  import {useRoute, useRouter} from 'vue-router';

  const {notifyError, notifySuccess} = toastify();
  const router = useRouter();
  const route = useRoute();
  const size = ref<SizeType>('large');
  const rangeDate = ref<{date: Date[]}>({date: []});
  const isSubmitting = ref(false);
  const disable = ref(true);
  const capabilies = ref<number>(0);
  const bookedTime = ref<{bookedList: string[]}>({bookedList: []});
  const errors = ref<LogBookCreateResType>({});
  const program = ref<DriverReadResType['data']>();
  const settings = ref<SettingResType['data']>();
  const formData = ref<LogBookCreateResType>({
    driver_test_id: Number(route.params.id),
    date_drive: '',
  });
  const {setError, reset, validateForm} = useForm(
    LogBookBodyRes,
    formData,
    errors
  );

  const timeSlots = ref([
    '07:00',
    '08:00',
    '08:30',
    '09:00',
    '09:30',
    '10:00',
    '10:30',
    '15:00',
    '15:30',
    '16:00',
    '16:30',
    '17:00',
    '17:30',
    '18:00',
    '18:30',
    '19:00',
    '19:30',
    '20:00',
    '20:30',
  ]);

  const onDateChange = (date: any, dateString: string) => {
    handleGetBooksInProgram();
  };

  // Hàm kiểm tra ngày có trong phạm vi không
  const disabledDate = (current: Date) => {
    const endTime = new Date(program.value.end_time);

    // Cộng thêm 1 ngày vào endTime
    endTime.setDate(endTime.getDate() + 1);

    return (
      new Date(current) < new Date(program.value.start_time) ||
      new Date(current) > endTime
    );
  };

  const selectTime = (time: string) => {
    formData.value.time_drive = time;
  };

  const filteredTimeSlots = computed(() => {
    if (
      !formData.value.date_drive ||
      !settings.value ||
      !program.value?.end_time
    ) {
      return [];
    }

    const dateParts = formData.value.date_drive.split('-');
    if (dateParts.length !== 3) {
      return [];
    }

    const formattedDate = `${dateParts[0]}-${dateParts[2]}-${dateParts[1]}`;

    const timeRange = settings.value.find(
      (item) => item.date === formattedDate
    );
    if (!timeRange) {
      return [];
    }

    const {start, end} = timeRange;
    const endTimeParts = program.value.end_time.split(' ');
    if (endTimeParts.length < 2) {
      return [];
    }

    const startTime = parseTime(start);
    const endTime = parseTime(end);
    const endProgramTime = parseTime(endTimeParts[1]);
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();

    if (startTime === null || endTime === null || endProgramTime === null) {
      return [];
    }

    disable.value = false;

    const isToday =
      new Date(formattedDate).toDateString() === new Date().toDateString();

    const availableSlots = timeSlots.value.filter((time) => {
      const timeInMinutes = parseTime(time);
      return (
        timeInMinutes !== null &&
        timeInMinutes >= startTime &&
        timeInMinutes <= endTime &&
        (isToday ? timeInMinutes >= currentTime : true)
      );
    });

    if (availableSlots.length === 0) {
      errors.value.time_drive = 'Ngày đã hết hạn vui lòng chọn ngày khác!';
    } else {
      errors.value.time_drive = '';
    }

    return availableSlots;
  });

  // Hàm chuyển đổi giờ phút (HH:mm) thành phút tính từ 00:00 để dễ so sánh
  function parseTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes; // Trả về tổng số phút từ 00:00
  }

  const handleCancel = () => {
    router.push(`/${route.params.id}/detail`);
  };

  // Hàm kiểm tra xem thời gian có bị disable không
  const isTimeDisabled = (time) => {
    try {
      // Check quá khứ
      const selectedDate = new Date(formData.value.date_drive);
      const [hours, minutes] = time.split(':');
      selectedDate.setHours(hours, minutes, 0, 0);
      if (selectedDate < new Date()) {
        return true;
      }
      // Check thời gian đã đặt
      return bookedTime.value.bookedList.includes(`${time}:00`);
    } catch (error) {
      console.error('Error in isTimeDisabled:', error);
      return false;
    }
  };

  const handleGetProgramById = async () => {
    try {
      const id = Number(route.params.id);
      if (id) {
        const result = await driverRequestApi.show(id);
        program.value = result.payload.data;
        handleGetCapabilities(program.value.id);
        handleGetDaySettings(program.value.id);
        // formData.value.date_drive = program.value.start_time
      }
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra!');
    }
  };

  const handleGetBooksInProgram = async () => {
    try {
      const body = {
        date_drive: formData.value.date_drive,
        id: Number(route.params.id),
      };
      const result = await booksRequestApi.check(body);
      bookedTime.value.bookedList = result.payload.data as string[];
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra vui lòng kiểm tra lại dữ liệu');
    }
  };

  const handleGetCapabilities = async (id: number) => {
    try {
      const result = await capasRequestApi.capa(id);
      capabilies.value = result.payload.data.quantity;
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra!');
    }
  };

  const handleGetDaySettings = async (id: number) => {
    try {
      const result = await settingsRequestApi.setting(id);
      settings.value = result.payload.data;

      settings.value.map((item) => {
        rangeDate.value.date.push(new Date(item.date));
      });
    } catch (error) {
      handleErrorApi({
        error,
        setError,
      });
      notifyError('Có lỗi xảy ra!');
    }
  };
  function stripTime(date: Date): Date {
    return new Date(date.getFullYear(), date.getMonth(), date.getDate());
  }

  const onSubmit = async () => {
    try {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      const result = await booksRequestApi.create(formData.value);
      if (result.status === 200) {
        Swal.fire({
          title: 'Thành công!',
          text: 'Đăng ký thành công',
          icon: 'success',
          confirmButtonText: 'OK',
        });
        reset();

        router.push('/');
      } else {
        notifyError('Đăng ký thất bại');
      }
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

  watch(
    () => formData.value.date_drive,
    (newDate) => {
      if (newDate) {
        handleGetBooksInProgram();
      }
    },
    {deep: true}
  );

  onMounted(() => {
    handleGetProgramById();
    handleGetBooksInProgram();
  });
</script>

<style scoped>
  @import url('../../assets/booking.css');
</style>
