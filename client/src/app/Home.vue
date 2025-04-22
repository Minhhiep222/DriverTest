<template>
  <div class="test-drive-programs-container bg-customBlack">
    <div class="w-full h-[35rem] relative group">
      <div>
        <a-carousel arrows autoplay>
          <template #prevArrow>
            <div class="custom-slick-arrow" style="left: 10px; z-index: 1">
              <left-circle-outlined />
            </div>
          </template>
          <template #nextArrow>
            <div class="custom-slick-arrow" style="right: 10px">
              <right-circle-outlined />
            </div>
          </template>
          <div>
            <div
              class="h-[33rem] flex flex-col justify-center items-center relative">
              <img
                src="../img/oto.jpg"
                alt=""
                class="w-full h-full absolute blur-sm brightness-90 top-0 left-0 -z-10 object-cover group-hover:scale-105 transition-all duration-300" />
              <h1 class="text-4xl text-white">Trải Nghiệm Lái Thử Đỉnh Cao</h1>
              <p class="subtitle text-lg text-white">
                Khám phá những mẫu xe mới nhất cùng các chương trình hấp dẫn.
              </p>
            </div>
          </div>
          <div>
            <div
              class="h-[33rem] flex flex-col justify-center items-center relative transition-all duration-300">
              <img
                src="../img/oto2.jpg"
                alt=""
                class="w-full h-full absolute group-hover:scale-105 transition-all duration-300 blur-sm brightness-90 top-0 left-0 -z-10 object-fill" />
              <h1 class="text-4xl text-white">Đăng Ký Dễ Dàng</h1>
              <p class="subtitle text-lg text-white">
                Chỉ với vài bước đơn giản, chọn lịch lái thử phù hợp với bạn.
              </p>
            </div>
          </div>
          <div>
            <div
              class="h-[33rem] flex flex-col justify-center items-center relative">
              <img
                src="../img/oto3.jpg"
                alt=""
                class="w-full h-full absolute blur-sm brightness-90 top-0 left-0 -z-10 object-cover group-hover:scale-105 transition-all duration-300" />
              <h1 class="text-4xl text-white">Ưu Đãi Đặc Biệt</h1>
              <p class="subtitle text-lg text-white">
                Tham gia lái thử để nhận ngay ưu đãi độc quyền và quà tặng hấp
                dẫn. Đừng bỏ lỡ cơ hội!
              </p>
            </div>
          </div>
        </a-carousel>
      </div>
      <!-- <div
        class="absolute bottom-0 md:bottom-8 left-1/2 -translate-x-1/2 w-2/3 rounded-md bg-white"
      >
        <div class="mb-3 mx-5 sm:mx-10 md:mx-20">
          <h3 class="text-xl sm:text-3xl font-semibold text-center mt-6 mb-4">
            Tìm chương trình lái thử bạn muốn
          </h3>
          <hr />
          <div
            class="mt-4 flex flex-col sm:flex-row gap-2 md justify-center md:justify-around items-center"
          >
            <div class="flex justify-between sm:flex-col gap-2 w-full">
              <span class="text-sm">Hãng xe: </span>
              <a-select
                ref="select"
                style="width: 120px"
                class="md:w-full"
              >
                <a-select-option value="jack">Jack</a-select-option>
              </a-select>
            </div>
            <div class="flex justify-between sm:flex-col gap-2 w-full">
              <span class="text-sm">Khu vực: </span>
              <a-select
                ref="select"
                style="width: 120px"
                class="md:w-full"
              >
                <a-select-option value="jack">Jack</a-select-option>
              </a-select>
            </div>
            <div class="flex justify-between sm:flex-col w-full gap-2">
              <span class="text-sm">Địa chỉ: </span>
              <a-select
                ref="select"
                style="width: 120px"
                class="md:w-full"
              >
                <a-select-option value="jack">Jack</a-select-option>
              </a-select>
            </div>
          </div>
        </div>
      </div> -->
    </div>
    <div class="header-section mt-8">
      <h2 class="title text-center text-3xl text-white">
        Khám Phá Chương Trình Lái Thử
      </h2>
    </div>

    <div class="grid sm:grid-cols-2 gap-3 lg:grid-cols-4 p-8">
      <div
        v-for="(program, index) in programs?.slice(0, 8)"
        :key="index"
        @click="handDetail(program)"
        class="mb-4 overflow-hidden cursor-pointer group relative hover:-translate-y-1 hover:shadow-white shadow-md duration-300 transition-all">
        <div
          :class="[
            'absolute ps-2 pe-5 z-10 top-2 left-2 flex text-sm items-center gap-3 text-white rounded-md',
            program.status === 'Active'
              ? 'bg-gradient-to-tr from-[#0DFF00] to-[#098D02]'
              : 'bg-gradient-to-tr from-[#F6B9B0] to-[#FB120A]',
          ]">
          <span class="text-2xl"> • </span>
          {{ program.status === 'Active' ? 'Đang diễn ra' : 'Hết hạn' }}
        </div>

        <div class="bg-white rounded h-[415px] max-h-[420px]">
          <div class="">
            <div class="w-full h-52 overflow-hidden relative">
              <!-- thiếu trường -->
              <img
                :src="image + program?.images[0]?.path"
                :alt="program?.name"
                @error="handleImageError"
                class="h-full w-auto mx-auto object-fit group-hover:scale-105 transition-all duration-300" />
              <!-- <div class="absolute z-10 text-white top-1/2 left-1/2 -translate-x-1/2 hidden group-hover:block transition-all duration-300">Xem chi tiết</div> -->
            </div>
            <h3
              class="uppercase mb-0.5 tracking-wide group-hover:underline mt-2 px-4 font-semibold text-black">
              {{ program.name.slice(0, 50) }}
            </h3>
            <div class="flex items-center px-4">
              <img src="../../public//star.svg" class="w-5" alt="" />
              <img src="../../public//star.svg" class="w-5" alt="" />
              <img src="../../public//star.svg" class="w-5" alt="" />
              <img src="../../public//star.svg" class="w-5" alt="" />
              <img src="../../public//star.svg" class="w-5" alt="" />
              (2.8)
            </div>
            <ul class="text-sm flex flex-col gap-0.5 px-4">
              <li class="mt-1 text-blue-400">
                {{ program?.showroom }}
              </li>
              <li class="flex items-center gap-1">
                <span class="flex"
                  ><img
                    src="../../public/clock.svg"
                    class="w-4 inline me-1"
                    alt="" />Thời gian:
                </span>
                <span class="">
                  {{ formatDateTime(program?.start_time) }} →
                  {{ formatDateTime(program?.end_time) }}
                </span>
              </li>
              <li>
                <span>
                  <img
                    src="../../public/location.svg"
                    class="w-4 inline me-1"
                    alt="" />Địa chỉ:</span
                >
                {{ program?.location }}
              </li>
              <li v-if="program?.description">
                <div
                  class="max-w-prose italic line-clamp-2 text-sm text-gray-700 leading-relaxed max-h-60 relative">
                  <p>{{ program.description }}</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
  // import '../../assets/testdriverUser.css';
  import driverRequestApi from '@/apiRequest/driver';
  import {LINK_TO_STORAGE} from '@/constants/path';
  import {handleImageError} from '@/lib/utils';
  import router from '@/router';
  import {DriverResType} from '@/schemaValidations/driver.schema';
  import {LeftCircleOutlined, RightCircleOutlined} from '@ant-design/icons-vue';
  import {onMounted, ref} from 'vue';
  import {formatDateTime} from '@/lib/utils';

  const programs = ref<DriverResType['data']>([]);
  const totalRecord = ref(0);
  const per_page = ref(10);
  const page = ref(1);
  const pageSizeOptions = ref<string[]>(['10', '20', '30', '40', '50', '100']);
  const key = ref<string>('');
  const image = ref(LINK_TO_STORAGE);
  const openDetail = ref<boolean>(false);
  const open = ref<boolean>(false);
  const imageLoaded = ref<boolean>(true);

  //chuyển qua chi tiết
  const handDetail = (program) => {
    router.push(`/${program.id}/detail`);
    location.href = `/${program.id}/detail`;
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

<style scoped>
  @import url('../assets/program.css');

  :deep(.slick-slide) {
    text-align: center;
    line-height: 160px;
    overflow: hidden;
  }

  :deep(.slick-arrow.custom-slick-arrow) {
    width: 25px;
    height: 25px;
    font-size: 25px;
    color: #fff;
    background-color: rgba(31, 45, 61, 0.11);
    transition: ease all 0.3s;
    opacity: 0.3;
    z-index: 1;
  }
  :deep(.slick-arrow.custom-slick-arrow:before) {
    display: none;
  }
  :deep(.slick-arrow.custom-slick-arrow:hover) {
    color: #fff;
    opacity: 0.5;
  }
</style>
