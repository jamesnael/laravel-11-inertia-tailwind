<template>
    <Head title="Supported By" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Create Supported By
            </h2>
        </template>

        <supported-by-form
            http-method="post"
            :action-uri="route('admin.homepage.supported-by.store')"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import supportedByForm from "@/Pages/Admin/Homepage/SupportedBy/Form.vue";


export default {
    name: "SupportedByCreate",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        supportedByForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        }
    },
};
</script>
