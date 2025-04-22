<template>
    <div>
        <Header></Header>
        <!-- <Menu></Menu> -->
        <section class="main min-h-full">
            <router-view />
        </section>
        <!-- footer -->
        <Footer className="mt-auto"></Footer>
    </div>
</template>

<script>

import Header from '@/layout/Component/Header.vue';
import Menu from '@/layout/Component/Menu.vue';
import Footer from '@/layout/Component/Footer.vue';

export default {
    name: 'HeaderOnly',
    components: {
        Header,
        Menu,
        Footer,
    },
};

</script>

<style>
/* Thêm các style cho layout */
.main {
    position: sticky;
    min-height: 100vh;
    background-color: #f9f9f9;
    /* Đảm bảo main luôn có chiều cao tối thiểu là chiều cao của viewport */
}
</style>
