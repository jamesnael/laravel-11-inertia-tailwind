<template>
    <Head title="About" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Edit About
            </h2>
        </template>

        <home-about-form
            http-method="put"
            :action-uri="
                route('admin.homepage.home-about.update', [homeabout.id])
            "
            :homeabout="homeabout"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import HomeAboutForm from "@/Pages/Admin/Homepage/About/Form.vue";

export default {
    name: "HomeAboutEdit",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        HomeAboutForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
        homeabout: {
            type: Object,
            default: () => null,
        },
    },
};
</script>