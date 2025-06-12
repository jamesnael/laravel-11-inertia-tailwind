<template>
  <Head title="History" />

  <admin-layout>
    <template #breadcrumbs>
      <Breadcrumb :breadcrumbs="breadcrumbs" />
    </template>
    
    <template #page-title>
      <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">Edit History</h2>
    </template>

    <history-form
      http-method="put"
      :action-uri="route('admin.about-us.history.update', [history.slug])"
      :history="history"
     />

  </admin-layout>
</template>

<script>
  import { Head, useForm } from '@inertiajs/inertia-vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import Breadcrumb from '@/Layouts/Breadcrumb.vue';
  import HistoryForm from '@/Pages/Admin/AboutUs/History/Form.vue';

  export default {
    name: 'MasterOurExpertCreate',
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
      history: {
        type: Object,
        default: () => null
      },
    }
  }
</script>