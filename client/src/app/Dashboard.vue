<template>
  <div>
    <p>User: {{ store.state.user }}</p>
    <p>Authenticated: {{ store.state.isAuthenticated }}</p>
    <button @click="store.dispatch('login', {name: 'John Doe'})">Login</button>
    <button @click="store.dispatch('logout')">Logout</button>
    <a href="/test">Logout</a>
  </div>
</template>

<script setup>
  import {useStore} from 'vuex';
  const store = useStore();
</script>
