<template>
    <Deatail :params="route" />
    <More :params="route" />
</template>

<script lang="ts" setup>
    import {useRoute, useRouter} from 'vue-router';
    import {ref} from 'vue';
    import More from '@/app/[driver]/[handle]/More.vue';
    import Deatail from '@/app/[driver]/[handle]/Detail.vue';
    import {onMounted} from 'vue';
    const router = useRouter();
    const route = useRoute();

    onMounted(() => {
        console.log('Minh', route.params);
    });
</script>
