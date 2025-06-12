<template>
  <Head title="Sliding Banner" />

  <admin-layout>
    <template #breadcrumbs>
      <Breadcrumb :breadcrumbs="breadcrumbs" />
    </template>
    
    <template #page-title>
      <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">Edit Sliding Banner</h2>
    </template>

    <banner-form
      http-method="put"
      :action-uri="route('admin.homepage.sliding-banner.update', [banner.slug])"
      :banner="banner"
     />

  </admin-layout>
</template>

<script>
  import { Head, useForm } from '@inertiajs/inertia-vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import Breadcrumb from '@/Layouts/Breadcrumb.vue';
  import BannerForm from '@/Pages/Admin/Homepage/SlidingBanner/Form.vue';

  export default {
    name: 'MasterBannerCreate',
    components: {
      Head,
      AdminLayout,
      Breadcrumb,
      BannerForm,
    },
    props: {
      breadcrumbs: {
        type: Array
      },
      banner: {
        type: Object,
        default: () => null
      }
    }
  }
</script>