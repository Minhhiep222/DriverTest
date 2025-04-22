<template>
  <div class="not-found">
    <h1>404</h1>
    <h2>Trang không tồn tại</h2>
    <p>Xin lỗi, trang bạn đang tìm kiếm không tồn tại.</p>
    <router-link to="/" class="home-link"> Quay về trang chủ </router-link>
  </div>
</template>

<script>
  export default {
    name: 'NotFound',
  };
</script>

<style scoped>
  .not-found {
    text-align: center;
    padding: 50px;
  }

  .home-link {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4caf50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
  }
</style>
