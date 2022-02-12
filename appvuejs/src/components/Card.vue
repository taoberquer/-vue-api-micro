<template>
  <div class="card" style="width: 18rem;">

<!--    <img class="card-img-top" src="../assets/logo.png" alt="Card image cap">-->
    <div class="card-image-top">
      <slot name="header"></slot>
    </div>
    <div class="card-body">
      <slot name="content"></slot>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Card',
  };
</script>
<style>
</style>
