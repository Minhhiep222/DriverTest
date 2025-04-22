<template>
  <Deatail :params="route" />
  <LogBook :params="route" />
  <!-- <More :params="route" /> -->
</template>

<script lang="ts" setup>
  import {useRoute, useRouter} from 'vue-router';
  import Deatail from '@/app/[driver]/[handle]/Detail.vue';
  import LogBook from '@/app/[driver]/Logbook.vue';
  import More from '@/app/[driver]/[handle]/More.vue';
  const route = useRoute();
</script>
