<template>
  <Head title="Role" />

  <admin-layout>
    <template #breadcrumbs>
      <Breadcrumb :breadcrumbs="breadcrumbs" />
    </template>
    
    <template #page-title>
      <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">Ubah Role</h2>
    </template>

    <role-form
      http-method="put"
      :action-uri="route('admin.data-master.role.update', [role.slug])"
      :role="role"
      :user-access="userAccess"
     />

  </admin-layout>
</template>

<script setup>
  import { Head, useForm } from '@inertiajs/inertia-vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import Breadcrumb from '@/Layouts/Breadcrumb.vue';
  import RoleForm from '@/Pages/Admin/DataMaster/Role/Form.vue';
  
  defineProps({
    breadcrumbs: {
      type: Array
    },
    userAccess: {
      type: Array,
      default: () => []
    },
    role: {
      type: Object,
      default: () => null
    }
  })
</script>