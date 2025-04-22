<template>
  <footer class="bg-gradient-to-r from-gray-900 to-black text-white py-12">
    <div class="container mx-auto pt-8 px-10">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mobile-footer-grid">
        <div>
          <img
            src="@/img/logo.png"
            alt="AutoDrive"
            class="w-40 mb-4 rounded-lg shadow-lg" />
          <p class="text-gray-400 text-sm leading-relaxed">
            Giải pháp toàn diện cho việc lái thử và thuê xe trực tuyến. Trải
            nghiệm lái thử dễ dàng, nhanh chóng.
          </p>
        </div>

        <div>
          <h3
            class="text-lg font-semibold mb-4 border-l-4 border-yellow-400 pl-3">
            Liên kết nhanh
          </h3>
          <ul class="space-y-2 text-gray-400">
            <li>
              <router-link to="/" class="footer-link">Trang chủ</router-link>
            </li>
            <li>
              <router-link to="/services" class="footer-link"
                >Dịch vụ</router-link
              >
            </li>
            <li>
              <router-link to="/test-drive" class="footer-link"
                >Đăng ký lái thử</router-link
              >
            </li>
            <li>
              <router-link to="/contact" class="footer-link"
                >Liên hệ</router-link
              >
            </li>
          </ul>
        </div>

        <div>
          <h3
            class="text-lg font-semibold mb-4 border-l-4 border-yellow-400 pl-3">
            Hỗ trợ khách hàng
          </h3>
          <ul class="space-y-2 text-gray-400">
            <li>
              <router-link to="/faq" class="footer-link"
                >Câu hỏi thường gặp</router-link
              >
            </li>
            <li>
              <router-link to="/privacy-policy" class="footer-link"
                >Chính sách bảo mật</router-link
              >
            </li>
            <li>
              <router-link to="/terms" class="footer-link"
                >Điều khoản sử dụng</router-link
              >
            </li>
          </ul>
        </div>

        <div>
          <h3
            class="text-lg font-semibold mb-4 border-l-4 border-yellow-400 pl-3">
            Liên hệ
          </h3>

          <div class="mb-2">
            <p class="text-gray-400 flex items-center">
              📧
              <a
                href="mailto:dangkylaithu@gmail.com"
                class="text-blue-500 hover:underline ml-2"
                >dangkylaithu@gmail.com</a
              >
            </p>
          </div>

          <div class="mb-2">
            <p class="text-gray-400 flex items-center">
              🌐
              <a
                href="https://masothue.com/0316021045-cong-ty-tnhh-dat-lich-bao-duong"
                target="_blank"
                class="text-blue-500 hover:underline ml-2"
                >Xem thông tin doanh nghiệp</a
              >
            </p>
          </div>
          <button
            @click="openContactForm"
            class="bg-yellow-400 text-white font-semibold px-4 py-2 rounded-md mt-3 hover:bg-yellow-500 transition">
            Liên hệ ngay
          </button>

          <div class="flex space-x-4 mt-4">
            <a href="#" class="social-icon text-gray-500 hover:text-blue-500"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a href="#" class="social-icon text-gray-500 hover:text-red-500"
              ><i class="fab fa-youtube"></i
            ></a>
            <a href="#" class="social-icon text-gray-500 hover:text-pink-500"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-700 text-center mt-8 pt-4">
        <p class="text-sm text-gray-400">Lái Thử</p>
      </div>
    </div>

    <!-- Form ẩn -->
    <div
      v-if="isContactFormOpen"
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center px-4">
      <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">
          📩 Gửi thông tin liên hệ
        </h3>

        <form @submit="submitContactForm" class="space-y-4">
          <div class="relative">
            <input
              type="text"
              placeholder="Họ và tên"
              required
              class="w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition" />
            <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
          </div>

          <div class="relative">
            <input
              type="email"
              placeholder="Email"
              required
              class="w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition" />
            <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
          </div>

          <div class="relative">
            <textarea
              placeholder="Nội dung"
              required
              rows="4"
              class="w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"></textarea>
            <i
              class="fas fa-comment-dots absolute left-3 top-3 text-gray-400"></i>
          </div>

          <button
            type="submit"
            class="w-full bg-yellow-400 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-yellow-500 transition">
            🚀 Gửi ngay
          </button>
        </form>

        <button
          @click="closeContactForm"
          class="w-full text-red-500 mt-4 font-medium hover:text-red-600 transition text-center">
          ✖ Đóng
        </button>
      </div>
    </div>
  </footer>
</template>

<script>
  export default {
    name: 'FooterComponent',
    data() {
      return {
        isContactFormOpen: false,
      };
    },
    methods: {
      openContactForm() {
        this.isContactFormOpen = true;
      },
      closeContactForm() {
        this.isContactFormOpen = false;
      },
      submitContactForm(e) {
        e.preventDefault();
        alert('Thông tin của bạn đã được gửi!');
        this.closeContactForm();
      },
    },
  };
</script>

<style>
  .footer-link {
    @apply block text-gray-400 hover:text-yellow-400 transition duration-300;
  }

  .social-icon {
    @apply text-gray-400 text-2xl hover:text-yellow-400 transition duration-300 transform hover:scale-110;
  }

  .footer-column {
    @apply flex flex-col space-y-2;
  }

  @media (max-width: 767px) {
    .mobile-footer-grid {
      grid-template-columns: 1fr;
      gap: 24px;
    }

    .mobile-footer-grid > div:first-child {
      display: none;
    }

    .mobile-footer-grid > div {
      text-align: center;
    }

    .mobile-footer-grid p,
    .mobile-footer-grid li {
      font-size: 1rem;
    }

    .mobile-footer-grid button {
      width: 100%;
    }

    .mobile-footer-grid .flex.space-x-4.mt-4 {
      justify-content: center;
    }

    .mobile-footer-grid .flex.space-x-4.mt-4 a:nth-child(n + 4) {
      display: none;
    }
  }
</style>
