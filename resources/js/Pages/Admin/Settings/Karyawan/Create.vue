<template>
  <Head title="User" />

  <admin-layout>
    <template #breadcrumbs>
      <Breadcrumb :breadcrumbs="breadcrumbs" />
    </template>
    
    <template #page-title>
      <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">Create User</h2>
    </template>

    <karyawan-form
      http-method="post"
      :action-uri="route('admin.settings.karyawan.store')"
      :jabatan="jabatan"
     />

  </admin-layout>
</template>

<script>
  import { Head, useForm } from '@inertiajs/inertia-vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import Breadcrumb from '@/Layouts/Breadcrumb.vue';
  import KaryawanForm from '@/Pages/Admin/Settings/Karyawan/Form.vue';

  export default {
    name: 'MasterKaryawanCreate',
    components: {
      Head,
      AdminLayout,
      Breadcrumb,
      KaryawanForm,
    },
    props: {
      breadcrumbs: {
        type: Array
      },
      jabatan: {
        type: Array,
        default: () => []
      }
    }
  }
</script>