<template>
  <menu v-if="user" class="menu_setting">
    <nav class="nav-menu">
      <ul class="menu h-10">
        <li
          v-if="user.role !== null"
          class="has-submenu"
          :class="{active: isActive(['/drive-management'])}">
          <a href="#" class="toggle-menu"> Quản lý chương trình </a>
          <ul class="submenu">
            <li>
              <router-link
                :to="{name: 'drive-management'}"
                :class="{active: isExactActive('/drive-management')}"
                >Chương trình lái thử</router-link
              >
            </li>
            <li>
              <router-link
                :to="{name: 'drive-reviews'}"
                :class="{active: isExactActive('/drive-reviews')}"
                >Kiểm duyệt chương trình</router-link
              >
            </li>
          </ul>
        </li>
        <li
          v-if="user.role !== null"
          class="has-submenu"
          :class="{
            active: isActive([
              '/Piority-User',
              '/customer-management',
              '/books',
            ]),
          }">
          <a href="#" class="toggle-menu">Quản lý khách hàng</a>
          <ul class="submenu">
            <li>
              <a
                href="Piority-User"
                :class="{active: isExactActive('/Piority-User')}"
                >Mức độ</a
              >
            </li>
            <li>
              <router-link
                :to="{name: 'customer-management'}"
                :class="{active: isExactActive('/customer-management')}"
                >Khách hàng</router-link
              >
            </li>
            <li>
              <router-link
                :to="{name: 'books'}"
                :class="{active: isExactActive('/books')}"
                >Khách hàng đăng ký</router-link
              >
            </li>
          </ul>
        </li>
        <li
          v-if="user.role === 'admin'"
          class="has-submenu"
          :class="{active: isActive(['/user-management'])}">
          <router-link
            class="toggle-menu"
            :to="{name: 'user-management'}"
            :class="{active: isExactActive('/user-management')}"
            >Quản lý người dùng
          </router-link>
        </li>

        <li
          v-if="user.role !== null"
          class="has-submenu"
          :class="{active: isActive(['/settings'])}">
          <a href="#" class="toggle-menu">Quản lý cài đặt</a>
          <ul class="submenu">
            <li>
              <router-link
                :to="{name: 'settings'}"
                :class="{active: isExactActive('/settings')}"
                >Cài đặt chương trình</router-link
              >
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </menu>
</template>

<script setup lang="ts">
  import '../../assets/header.css';
  import '../../assets/menu.css';
  import {onMounted, ref} from 'vue';
  import {useStore} from 'vuex';
  import {useRouter, useRoute} from 'vue-router';
  import authRequestApi from '@/apiRequest/auth';
  import {AccountResType} from '@/schemaValidations/auth.schema';

  const route = useRoute();
  const store = useStore();

  const user = ref<AccountResType['data']>(null);

  const isExactActive = (path: string) => {
    return route.path === path;
  };

  const isActive = (paths: string[]) => {
    return paths.some((path) => route.path.startsWith(path));
  };

  const me = async () => {
    const result = await authRequestApi.me();
    if (result) {
      user.value = result.payload.data;
    }
  };

  onMounted(() => {
    me();
  });
</script>
