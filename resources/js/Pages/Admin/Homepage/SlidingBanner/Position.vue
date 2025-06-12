<template>
    <Head title="Secondary Sliding Banner" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Edit Secondary Sliding Banner Position
            </h2>
        </template>

        <sliding-banner-position-form
            http-method="post"
            :action-uri="route('admin.homepage.sliding-banner.store-position')"
            :sliding-banner="data"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import SlidingBannerPositionForm from "@/Pages/Admin/Homepage/SlidingBanner/PositionForm.vue";

export default {
    name: "SlidingBannerPosition",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        SlidingBannerPositionForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
        data: {
            type: Array,
        },
    },
};
</script>
