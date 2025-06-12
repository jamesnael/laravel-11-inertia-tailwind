<template>
  <Head title="History" />

  <admin-layout>
    <template #breadcrumbs>
      <Breadcrumb :breadcrumbs="breadcrumbs" />
    </template>
    
    <template #page-title>
      <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">Create History</h2>
    </template>

    <history-form
      http-method="post"
      :action-uri="route('admin.about-us.history.store')"
     />

  </admin-layout>
</template>

<script>
  import { Head, useForm } from '@inertiajs/inertia-vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import Breadcrumb from '@/Layouts/Breadcrumb.vue';
  import HistoryForm from '@/Pages/Admin/AboutUs/History/Form.vue';

  export default {
    name: 'AboutOurExpertCreate',
    components: {
      Head,
      AdminLayout,
      Breadcrumb,
      HistoryForm,
    },
    props: {
      breadcrumbs: {
        type: Array
      },
    }
  }
</script>