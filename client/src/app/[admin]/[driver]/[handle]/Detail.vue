<template>
  <Deatail :params="route" />
  <More :params="route" />
</template>

<script lang="ts" setup>
  import {useRoute, useRouter} from 'vue-router';
  import Deatail from '@/app/[admin]/[driver]/[handle]/View.vue';
  import More from '@/app/[driver]/[handle]/More.vue';
  const route = useRoute();
</script>
