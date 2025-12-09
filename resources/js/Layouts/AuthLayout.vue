<template>
  <div class="h-screen flex flex-col justify-center items-center px-4">
    <div class="flex flex-row w-full sm:max-w-md items-center justify-between mb-6">
      <a href="#!">
        <logo-image class="w-10 h-10" />
      </a>
      <slot name="title">
        <span class="font-extrabold tracking-wide">Masuk ke Admin Panel</span>
      </slot>
    </div>

    <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <slot />
    </div>

    <small class="mt-5 tracking-wide">{{ new Date().getFullYear() }} &copy; ProjectName. All Rights Reserved.</small>
  </div>
</template>

<script>
  import { Link } from '@inertiajs/inertia-vue3';
  import LogoImage from '@/Layouts/LogoImage.vue';

  export default {
    name: 'AuthLayout',
    components: {
      Link,
      LogoImage
    }
  }
</script>
