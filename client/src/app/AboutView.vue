<template>
  <div class="about block">
    <h1 class="text-xl text-center font-bold hover:text-customBlack transition-all duration-150 bg-red">This is an about page</h1>
    <ul class="flex gap-1 text-2xl md:text-green-300 lg:text-blue-500">
      <li>1</li>
      <li>2</li>
      <li>3</li>
      <li>4</li>
    </ul>
  </div>
</template>
sm
md 
lg 
<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
