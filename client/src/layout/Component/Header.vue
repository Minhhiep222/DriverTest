<template>
  <header class="header">
    <nav
      :class="{'nav-menu': true, 'mobile-active': isMenuOpen}"
      class="w-full">
      <img @click="home" class="logo" src="@/img/logo.png" alt="Logo" />

      <button @click="toggleMenu" class="menu-toggle">☰</button>

      <ul v-if="user" class="menu w-full">
        <!-- Dùng chung -->
        <!-- <li class="has-submenu" :class="{ open: isOpenSubmenu('care') }" @click="toggleSubmenu('care')"
            @mouseenter="handleMouseEnter('care')" @mouseleave="handleMouseLeave('care')">
            <a href="#" class="toggle-menu" :class="{ active: isMenuActive('care') }">
              Dùng Chung
            </a>

            <ul class="submenu" :class="{ 'submenu-visible': submenus.care }">
              <li>
                <a href="#" @click="closeMenuOnMobile">Hãng Xe</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Dòng Xe</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Màu Sắc</a>
              </li>
            </ul>
          </li> -->
        <li
          v-if="user.role === 'admin'"
          class="has-submenu admin"
          :class="{
            open: isOpenSubmenu('profile'),
            active: isActive(['/admin']),
          }"
          @click="toggleSubmenu('profile')"
          @mouseenter="handleMouseEnter('profile')"
          @mouseleave="handleMouseLeave('profile')">
          <router-link
            :to="{name: 'admin'}"
            :class="{active: isExactActive('/admin')}"
            @click="closeMenuOnMobile">
            Trang Admin
          </router-link>
        </li>

        <!-- Chương trình -->
        <li
          class="has-submenu"
          :class="{
            open: isOpenSubmenu('program'),
            active: isActive(['/drive-management', '/drive-reviews']),
          }"
          @click="toggleSubmenu('program')"
          @mouseenter="handleMouseEnter('program')"
          @mouseleave="handleMouseLeave('program')">
          <a
            href="#"
            class="toggle-menu"
            :class="{active: isMenuActive('program')}">
            Chương Trình
          </a>

          <ul class="submenu" :class="{'submenu-visible': submenus.program}">
            <li>
              <router-link
                :to="{name: 'drive-management'}"
                :class="{active: isExactActive('/drive-management')}"
                @click="closeMenuOnMobile">
                Chương Trình Lái Thử
              </router-link>
            </li>
            <li v-if="user.role === 'admin'">
              <router-link
                :to="{name: 'drive-reviews'}"
                :class="{active: isExactActive('/drive-reviews')}"
                >Kiểm duyệt chương trình</router-link
              >
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Bảng Báo Giá</a>
            </li>
          </ul>
        </li>

        <!-- Khách hàng -->
        <li
          class="has-submenu"
          :class="{
            open: isOpenSubmenu('customer'),
            active: isActive(['/customer-management']),
          }"
          @click="toggleSubmenu('customer')"
          @mouseenter="handleMouseEnter('customer')"
          @mouseleave="handleMouseLeave('customer')">
          <a href="#" class="toggle-menu"> Khách Hàng </a>

          <ul class="submenu" :class="{'submenu-visible': submenus.customer}">
            <li>
              <router-link
                :to="{name: 'customer-management'}"
                :class="{active: isExactActive('/customer-management')}"
                @click="closeMenuOnMobile">
                Danh Sách Khách Hàng
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'books'}" @click="closeMenuOnMobile">
                Quản lý khách hàng lái thử
              </router-link>
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Công Ty Bảo Hiểm</a>
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Ngân Hàng</a>
            </li>
          </ul>
        </li>

        <!-- Showroom -->
        <li
          v-if="user.role === 'admin'"
          class="has-submenu"
          :class="{
            open: isOpenSubmenu('showroom'),
            active: isActive(['/user-management']),
          }"
          @click="toggleSubmenu('showroom')"
          @mouseenter="handleMouseEnter('showroom')"
          @mouseleave="handleMouseLeave('showroom')">
          <a
            href="#"
            class="toggle-menu"
            :class="{active: isMenuActive('showroom')}">
            Quản Lý Showroom
          </a>

          <ul class="submenu" :class="{'submenu-visible': submenus.showroom}">
            <li>
              <router-link
                :to="{name: 'user-management'}"
                :class="{active: isExactActive('/user-management')}"
                @click="closeMenuOnMobile">
                Quản lý người dùng
              </router-link>
            </li>
          </ul>
        </li>

        <!-- Chăm sóc khách hàng -->
        <!-- <li
            class="has-submenu"
            :class="{open: isOpenSubmenu('take')}"
            @click="toggleSubmenu('take')"
            @mouseenter="handleMouseEnter('take')"
            @mouseleave="handleMouseLeave('take')">
            <a
              href="#"
              class="toggle-menu"
              :class="{active: isMenuActive('take')}">
              Chăm Sóc Khách Hàng
            </a>

            <ul class="submenu" :class="{'submenu-visible': submenus.take}">
              <li>
                <a href="#" @click="closeMenuOnMobile">Danh Sách</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Chương Trình Chăm Sóc</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Chiến Dịch Chăm Sóc</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Thu Thập & Check List</a>
              </li>
            </ul>
          </li> -->

        <!-- Marketing -->
        <!-- <li class="has-submenu" :class="{ open: isOpenSubmenu('Marke') }" @click="toggleSubmenu('Marke')"
            @mouseenter="handleMouseEnter('Marke')" @mouseleave="handleMouseLeave('Marke')">
            <a href="#" class="toggle-menu" :class="{ active: isMenuActive('Marke') }">
              Marketing
            </a>

            <ul class="submenu" :class="{ 'submenu-visible': submenus.Marke }">
              <li>
                <a href="#" @click="closeMenuOnMobile">Chương Trình</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Tiếp Thị Liên Kết</a>
              </li>

            </ul>
          </li> -->

        <!-- Báo Cáo -->
        <!-- <li class="has-submenu" :class="{ open: isOpenSubmenu('rapport') }" @click="toggleSubmenu('rapport')"
            @mouseenter="handleMouseEnter('rapport')" @mouseleave="handleMouseLeave('rapport')">
            <a href="#" class="toggle-menu" :class="{ active: isMenuActive('rapport') }">
              Báo Cáo
            </a>

            <ul class="submenu" :class="{ 'submenu-visible': submenus.rapport }">
              <li>
                <a href="#" @click="closeMenuOnMobile">Chương Trình</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Khách Hàng</a>
              </li>

            </ul>
          </li> -->

        <!-- Người Dùng -->
        <!-- <li class="has-submenu" :class="{ open: isOpenSubmenu('user') }" @click="toggleSubmenu('user')"
            @mouseenter="handleMouseEnter('user')" @mouseleave="handleMouseLeave('user')">
            <a href="#" class="toggle-menu" :class="{ active: isMenuActive('user') }">
              Người Dùng
            </a>

            <ul class="submenu" :class="{ 'submenu-visible': submenus.user }">
              <li>
                <a href="#" @click="closeMenuOnMobile">Nhân Sự</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Người Dùng</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Nhóm Nhân Sự</a>
              </li>
              <li>
                <a href="#" @click="closeMenuOnMobile">Vai Trò</a>
              </li>
            </ul>
          </li> -->

        <!-- Cài Đặt -->

        <li
          class="has-submenu"
          :class="{
            open: isOpenSubmenu('setting'),
            active: isActive(['/settings']),
          }"
          @click="toggleSubmenu('setting')"
          @mouseenter="handleMouseEnter('setting')"
          @mouseleave="handleMouseLeave('setting')">
          <a
            href="#"
            class="toggle-menu"
            :class="{active: isMenuActive('settings')}">
            Cài Đặt
          </a>

          <ul class="submenu" :class="{'submenu-visible': submenus.setting}">
            <li>
              <router-link
                :to="{name: 'settings'}"
                :class="{active: isExactActive('/settings')}"
                @click="closeMenuOnMobile">
                Cài Đặt Chương Trình
              </router-link>
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Mẫu Đăng Ký Lái Thử</a>
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Trung Tâm</a>
            </li>
            <li>
              <a href="#" @click="closeMenuOnMobile">Kho Dữ Liệu Web</a>
            </li>
          </ul>
        </li>

        <li
          v-if="user.role !== 'admin'"
          class="has-submenu me"
          :class="{
            open: isOpenSubmenu('profile'),
            active: isActive(['/me']),
          }"
          @click="toggleSubmenu('profile')"
          @mouseenter="handleMouseEnter('profile')"
          @mouseleave="handleMouseLeave('profile')">
          <router-link
            :to="{name: 'me'}"
            :class="{active: isExactActive('/me')}"
            @click="closeMenuOnMobile">
            Hồ sơ
          </router-link>
        </li>
      </ul>

      <ul class="menu">
        <ul v-if="user" class="flex items-center justify-end gap-2">
          <li
            class="profile-group has-submenu border-r-0 flex items-center justify-between gap-2"
            @click="toggleSubmenu('profile')"
            :class="{
              open: isOpenSubmenu('profile'),
            }"
            @mouseenter="handleMouseEnter('profile')"
            @mouseleave="handleMouseLeave('profile')">
            <div class="flex items-center justify-between gap-2">
              <img src="@/img/avatar.jpg" alt="Avatar" class="avatar" />
              <span>{{ store.state.user.name }}</span>
            </div>

            <ul
              class="submenu profile min-w-[100px] flex flex-col"
              :class="{'submenu-visible': submenus.profile}">
              <li v-if="user.role !== 'admin'" class="w-full text-center">
                <router-link
                  :to="{name: 'me'}"
                  :class="{active: isExactActive('/me')}"
                  @click="closeMenuOnMobile">
                  Hồ sơ
                </router-link>
              </li>
              <li v-if="user.role === 'admin'" class="w-full text-center">
                <router-link
                  :to="{name: 'admin'}"
                  :class="{active: isExactActive('/admin')}"
                  @click="closeMenuOnMobile">
                  Admin
                </router-link>
              </li>
              <li class="w-full">
                <a-button class="w-full rounded-none" @click="logout"
                  >Đăng xuất</a-button
                >
              </li>
            </ul>

            <div class="btn-group-mobile flex">
              <a-button class="rounded-none" @click="logout"
                >Đăng xuất</a-button
              >
            </div>
          </li>
        </ul>
        <ul v-else class="flex items-center justify-end gap-2">
          <li><a-button @click="login">Đăng nhập</a-button></li>
          <li><a-button @click="register">Đăng ký</a-button></li>
        </ul>
      </ul>
    </nav>
  </header>
</template>

<script setup lang="ts">
  import authRequestApi from '@/apiRequest/auth';
  import {AccountResType} from '@/schemaValidations/auth.schema';
  import {onBeforeUnmount, onMounted, ref} from 'vue';
  import {useRoute, useRouter} from 'vue-router';
  import {useStore} from 'vuex';

  const user = ref<AccountResType['data']>(null);
  const store = useStore();
  const router = useRouter();
  const route = useRoute();

  const submenus = ref({
    program: false,
    customer: false,
    care: false,
    rapport: false,
    Marke: false,
    take: false,
    user: false,
    setting: false,
    showroom: false,
    profile: false,
  });
  const isLoggedIn = ref(false);
  const activeMenu = ref(null);
  const isMenuOpen = ref(false);
  let isHovering = ref(false);
  let hoverTimeout = ref<number | null>(null);
  const name = ref<string>('');

  const isExactActive = (path: string) => {
    return route.path === path;
  };

  const isActive = (paths: string[]) => {
    return paths.some((path) => route.path.startsWith(path));
  };

  const handleMouseEnter = (key: string) => {
    isHovering.value = true;
    if (hoverTimeout.value) {
      clearTimeout(hoverTimeout.value);
    }
    submenus.value[key] = true;
  };

  const handleMouseLeave = (key: string) => {
    isHovering.value = false;
    hoverTimeout.value = window.setTimeout(() => {
      if (!isHovering.value) {
        submenus.value[key] = false;
      }
    }, 100);
  };

  const home = () => {
    router.push('/');
  };

  const login = () => {
    router.push({name: 'login'});
  };

  const register = () => {
    router.push({name: 'register'});
  };

  const logout = () => {
    isLoggedIn.value = false;
    user.value = null;
    store.commit('logout');
  };

  const isSubmenu = (el: HTMLElement | null): boolean => {
    if (!el) return false;
    if (el.classList?.contains('has-submenu')) return true;
    return el.parentElement ? isSubmenu(el.parentElement) : false;
  };

  const me = async () => {
    user.value = localStorage.getItem('user') as AccountResType['data'];
    if (user.value !== null) {
      const result = await authRequestApi.me();
      user.value = result.payload.data;
      name.value = user.value.name;
    }
    if (store.state.user.name) {
      name.value = store.state.user.name;
    }
  };

  onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
    me();
  });

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleDocumentClick);
  });

  const isMenuActive = (key: string) => {
    const routeName = router.currentRoute.value.name;
    return typeof routeName === 'string' && routeName.startsWith(key);
  };

  const toggleSubmenu = (key: string) => {
    Object.keys(submenus.value).forEach((menu) => {
      if (menu !== key) submenus.value[menu] = false;
    });
    submenus.value[key] = !submenus.value[key];
  };

  const isOpenSubmenu = (key: string) => {
    return submenus.value[key];
  };

  const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
  };

  const closeMenuOnMobile = () => {
    if (window.innerWidth <= 768) {
      isMenuOpen.value = false;
    }
  };

  const handleDocumentClick = (event: MouseEvent) => {
    if (!isSubmenu(event.target as HTMLElement)) {
      Object.keys(submenus.value).forEach((menu) => {
        submenus.value[menu] = false;
      });
    }
  };
</script>

<style>
  @import url('../../assets/header.css');
</style>
