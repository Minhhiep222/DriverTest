<template>
    <div class="booking relative min-h-screen bg-cover bg-center bg-no-repeat">
        <div class="container mx-auto px-4 py-24 relative z-10">
            <h1 class="text-4xl font-bold text-white text-center mb-4">Đăng Ký Lái Thử</h1>
            <p class="text-lg text-gray-300 text-center mb-8">
                Chọn thời gian và địa điểm phù hợp, để chúng tôi mang lại trải nghiệm tối ưu nhất cho bạn.
            </p>

            <div class="bg-white bg-opacity-20 rounded-lg shadow-lg p-8 max-w-lg mx-auto">
                <h2 class="text-xl font-semibold text-white mb-6">Thông Tin Liên Hệ</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="khuVuc" class="block text-gray-200 text-sm font-bold mb-2">Khu Vực</label>
                        <select id="khuVuc" v-model="form.khuVuc"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Chọn khu vực</option>
                            <option value="hanoi">Hà Nội</option>
                            <option value="tphcm">TP.HCM</option>
                        </select>
                    </div>
                    <div>
                        <label for="soDienThoai" class="block text-gray-200 text-sm font-bold mb-2">Số Điện
                            Thoại</label>
                        <input type="tel" id="soDienThoai" v-model="form.soDienThoai"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Nhập số điện thoại">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-gray-200 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" v-model="form.email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-6"
                        placeholder="Nhập email">
                </div>

                <h2 class="text-xl font-semibold text-white mb-6">Thông Tin Khách Hàng</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="hoTen" class="block text-gray-200 text-sm font-bold mb-2">Họ Tên</label>
                        <input type="text" id="hoTen" v-model="form.hoTen"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Nhập họ tên">
                    </div>
                    <div>
                        <label for="gioiTinh" class="block text-gray-200 text-sm font-bold mb-2">Giới Tính</label>
                        <select id="gioiTinh" v-model="form.gioiTinh"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="tuoi" class="block text-gray-200 text-sm font-bold mb-2">Tuổi</label>
                        <input type="number" id="tuoi" v-model="form.tuoi"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Nhập tuổi">
                    </div>
                    <div>
                        <label for="thoiGianDuKien" class="block text-gray-200 text-sm font-bold mb-2">Thời Gian Dự
                            Kiến</label>
                        <div class="relative">
                            <input type="date" id="thoiGianDuKien" v-model="form.thoiGianDuKien"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Quay Lại
                    </button>
                    <button @click="handleSubmit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Đăng Ký
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const form = ref({
            khuVuc: '',
            soDienThoai: '',
            email: '',
            hoTen: '',
            gioiTinh: '',
            tuoi: '',
            thoiGianDuKien: '',
        });

        const handleSubmit = () => {
            console.log('Form data:', form.value);
            alert('Đăng ký thành công!');
        };

        return {
            form,
            handleSubmit,
        };
    },
};
</script>
<style>
.booking {
    background-image: url(@/img/oto2.jpg);
    /* position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: black;
    opacity: 0.7;
    pointer-events: none; */
}
</style>