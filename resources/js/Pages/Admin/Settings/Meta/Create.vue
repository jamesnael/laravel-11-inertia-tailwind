<template>
    <Head title="Meta" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Create Meta
            </h2>
        </template>

        <meta-form
            http-method="post"
            :action-uri="
                route('admin.settings.meta.store')
            "
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import MetaForm from "@/Pages/Admin/Settings/Meta/Form.vue";

export default {
    name: "MasterAuthorCreate",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        MetaForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
    },
};
</script>
