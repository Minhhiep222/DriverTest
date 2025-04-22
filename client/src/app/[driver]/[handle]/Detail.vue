<template>
  <!-- <div class="test-drive-details-user bg-customBlack">
    <div class="product-card">
      <div
        class="product-image-container"
        style="background-size: cover"
        :style="{
          backgroundImage: `url(${image + detail?.images[0]?.path})`,
        }"></div>

      <div class="product-info">
        <div class="p-3">
          <h2 class="product-title">{{ detail?.name }}</h2>
          <div class="info-row">
            <span class="label">Hãng:</span>
            <span class="value">{{ detail?.showroom }}</span>
          </div>
          <div class="info-row">
            <span class="label">Bắt đầu:</span>
            <span class="value">{{ detail?.start_time }}</span>
          </div>
          <div class="info-row">
            <span class="label">Kết thúc:</span>
            <span class="value">{{ detail?.end_time }}</span>
          </div>
          <div class="info-row">
            <span class="label">Loại xe:</span>
            <span class="value">{{ detail?.vehicle_type }}</span>
          </div>
          <div class="description-container">
            <span class="label">Mô tả:</span>
            <p class="description-text">{{ detail?.description }}</p>
          </div>
          <div class="info-row status-row">
            <span class="label">Trạng thái:</span>
            <span :class="{status: true, active: detail?.status === 'Active'}">
              {{ detail?.status === 'Inactive' ? 'Kết thúc' : 'Đang diễn ra' }}
            </span>
          </div>
          <div class="button-container">
            <button
              class="register-button"
              @click="() => handleBooking(detail.id)">
              Tham gia chương trình
            </button>
            <button class="back-button" @click="handleBack">Quay lại</button>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="bg-customBlack px-5 md:px-20 pt-12 pb-20 text-white">
    <div class="flex flex-col relative">
      <div class="mb-10 md:absolute top-0 z-10 right-0 flex gap-2">
        <img
          src="@root/public/save.svg"
          alt=""
          class="cursor-pointer hover:brightness-75" />
        <img
          src="@root/public/share.svg"
          alt=""
          class="cursor-pointer hover:brightness-75" />
      </div>
      <h1 class="text-3xl font-semibold relative">{{ detail?.name }}</h1>
      <div class="text-lg font-medium relative flex gap-2 mb-1"> <img src="@root/public/car.svg" alt="" /> {{ detail?.showroom }}</div>
      <div class="opacity-90">
        <!-- <p class="flex items-center capitalize flex-wrap gap-2">
          <img src="@root/public/car.svg" alt="" />
          Loại xe: {{ detail?.vehicle_type }}
        </p> -->
        <p class="flex items-center flex-wrap gap-2 mb-1">
          <img src="@root/public/location2.svg" alt="" />
          {{ detail?.location }}
          <span
            class="text-green-500 md:ms-5 cursor-pointer hover:underline font-semibold"
            >Xem bản đồ</span
          >
        </p>
        <p class="flex items-center gap-2">
          <img src="@root/public/date.svg" alt="" />
          Từ
          <span class="font-semibold">
            {{ formatDateTime(detail?.start_time, true) }}
          </span>
          Đến
          <span class="font-semibold">
            {{ formatDateTime(detail?.end_time, true) }}
          </span>
        </p>
      </div>
    </div>
    <div class="max-w-7xl mx-auto">
      <template v-if="detail?.images?.length >= 5">
        <div class="grid md:grid-cols-2 gap-2">
          <a-image-preview-group>
            <div class="w-full h-full detail">
              <a-image
                :src="LINK_TO_STORAGE + detail.images[0].path"
                class="w-full h-full object-fill rounded-lg" />
            </div>
            <div class="grid grid-cols-2 gap-2 detail">
              <a-image
                v-for="(img, index) in detail?.images.slice(1, 4)"
                :key="index"
                :src="LINK_TO_STORAGE + img.path"
                class="h-full w-full object-center rounded-lg" />
              <div class="relative h-full">
                <a-image
                  :height="250"
                  :src="LINK_TO_STORAGE + detail.images[4].path"
                  :class="
                    detail.images.length > 5
                      ? 'w-full h-full object-center rounded-lg brightness-50'
                      : 'w-full h-full object-center rounded-lg'
                  " />
                <div
                  v-if="detail?.images.length > 5"
                  class="absolute inset-0 flex justify-center items-center backdrop-blur-sm">
                  <span class="text-white"
                    >+ {{ detail?.images.length - 5 }} ảnh khác
                  </span>
                </div>
              </div>
            </div>
            <a-image
              v-for="(img, index) in detail?.images.slice(5)"
              :key="index"
              :width="250"
              :src="LINK_TO_STORAGE + img.path"
              class="h-full hidden object-center rounded-lg" />
          </a-image-preview-group>
        </div>
      </template>
      <template v-else>
        <div class="flex gap-2">
          <a-image-preview-group>
            <a-image
              v-for="(img, index) in detail?.images"
              :key="index"
              :width="200"
              :src="LINK_TO_STORAGE + img.path"
              class="w-full h-auto object-cover rounded-lg" />
          </a-image-preview-group>
        </div>
      </template>
    </div>
    <div class="grid gap-2 md:grid-cols-5 mt-4">
      <div
        class="grid lg:grid-cols-2 bg-white rounded-md text-[#1BA0E2] px-2 py-3 items-center gap-4">
        <div
          class="text-center flex justify-center lg:justify-start items-center bg-gradient-to-tr from-[#F5FBFF] via-[#D1F0FF] to-[#F5FBFF] p-1">
          <img
            src="@root/public/review.detail.svg"
            alt=""
            class="inline me-1" />
          <span class="text-[#0071CE] text-2xl font-semibold">9,1</span>
          <span>/10</span>
        </div>
        <div
          class="text-black ms-2 lg:ms-0 flex items-start font-semibold flex-col justify-center">
          Xuất sắc
          <p
            class="mb-0 flex items-center text-[#0071CE] font-bold cursor-pointer hover:underline">
            38 Đánh giá
          </p>
        </div>
      </div>
      <div
        class="bg-white cursor-pointer group hover:brightness-95 duration-200 transition-all text-[#0264C8] col-span-2 rounded-md flex justify-start gap-3 items-center ps-2 py-3">
        <img src="@root/public/location.detail.svg" alt="" />
        <div class="ms-2">
          <p class="mb-0 font-bold text-black">Tìm đường ngay</p>
          <span
            class="flex items-center font-semibold gap-1 group-hover:underline"
            >Xem bản đồ <RightOutlined
          /></span>
        </div>
      </div>
      <div
        class="flex justify-around items-center bg-[#FFF4EF] text-[#242628] col-span-2 rounded-md">
        <p class="font-bold text-center mb-0 py-3">
          Trải nghiệm thực tế. <br />Lái thử ngay!
        </p>
        <button
          @click="() => handleBooking(detail.id)"
          class="rounded-3xl bg-[#FD5D1C] px-4 hover:brightness-95 py-3 text-white font-bold">
          Tham Gia Ngay
        </button>
      </div>
    </div>
    <div class="grid gap-2 grid-cols-1 md:grid-cols-5 mt-2">
      <div class="md:col-span-3 bg-white rounded-md py-4 ps-12 pe-8">
        <h6 class="text-[#0264C8] font-bold">Mô tả:</h6>
        <p class="text-[#242628]">{{ detail?.description }}</p>
      </div>
      <div class="md:col-span-2 w-full bg-white rounded-md p-4">
        <img src="@root/public/comment.detail.svg" class="mx-auto" alt="" />
        <p class="text-[#03121A] text-center font-bold mb-1 text-lg">
          Để lại đánh giá
        </p>
        <p class="text-[#687176] mx-10 text-center text-sm">
          Điều này sẽ giúp các Doanh Nghiệp lên kế hoạch phù hợp và hoàn thiện
          hơn.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
  import driverRequestApi from '@/apiRequest/driver';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import {formatDateTime} from '@/lib/utils';
  import {DriverResType} from '@/schemaValidations/driver.schema';
  import {RightOutlined} from '@ant-design/icons-vue';
  import {onMounted, ref, watch} from 'vue';
  import {RouteLocationNormalizedLoaded, useRouter} from 'vue-router';
  const router = useRouter();

  const props = defineProps<{
    params: RouteLocationNormalizedLoaded;
  }>();

  const detail = ref<DriverResType['data'][0]>({images: [{path: ''}]}); // DriverResType['data'][0]

  const handleBooking = (id: number) => {
    router.push(`/${id}/booking`);
  };

  const fetchDriveData = async (id: number) => {
    try {
      const response = await driverRequestApi.show(id);
      detail.value = response.payload.data;
    } catch (error) {
      console.error('Lỗi khi lấy thông tin chi tiết:', error);
    }
  };

  const handleBack = () => {
    router.push('/');
  };

  watch(
    () => props.params,
    () => {},
    {deep: true}
  );

  onMounted(() => {
    const id = props.params.params.id;
    if (id) {
      fetchDriveData(parseInt(Array.isArray(id) ? id[0] : id));
    }
  });
</script>

<style cored>
  @import url('../../../assets/Detail.css');
</style>
