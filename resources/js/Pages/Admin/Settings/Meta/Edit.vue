<template>
    <Head title="Meta" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Edit Meta
            </h2>
        </template>

        <meta-form
            http-method="put"
            :action-uri="
                route('admin.settings.meta.update', [
                    meta.slug,
                ])
            "
            :meta="meta"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import MetaForm from "@/Pages/Admin/Settings/Meta/Form.vue";

export default {
    name: "MasterAuthorEdit",
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
        meta: {
            type: Object,
            default: () => null,
        },
    },
};
</script>
