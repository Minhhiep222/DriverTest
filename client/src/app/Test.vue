<template>
  <div>
    <p>User: {{ store.state.user }}</p>
    <p>Authenticated: {{ store.state.isAuthenticated }}</p>
  </div>
</template>

<script setup>
  import {useStore} from 'vuex';
  const store = useStore();
</script>
