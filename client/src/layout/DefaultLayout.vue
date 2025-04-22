<template>
    <div className="min-h-screen flex flex-col">
        <!-- Header -->
        <Header></Header>
        <div className="min-h-screen flex flex-col md:flex-row">
            <!-- Sidebar -->
            <Sidebar className="bg-white w-full md:w-1/6 lg:w-1/6" />

            <!-- container -->
            <div className="flex-1 p-4">
                <router-view />
            </div>
        </div>

        <!-- footer -->
        <Footer className="mt-auto"></Footer>
    </div>
</template>

<script>
    import Header from '@/layout/Component/Header.vue';
    import Footer from '@/layout/Component/Footer.vue';
    import Sidebar from '@/layout/Component/Sidebar.vue';
    export default {
        name: 'DefaultLayout',
        components: {
            Header,
            Sidebar,
            Footer,
        },
    };
</script>
