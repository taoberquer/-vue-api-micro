<template>
  <div class="d-flex w-auto">
<!--    <img class="card-img-top" src="../assets/logo.png" alt="Card image cap">-->
    <div class="card-img">
      <slot name="img"></slot>
    </div>
    <div class="text-left mt-1">
      <slot name="infos"></slot>
    </div>
  </div>
</template>
