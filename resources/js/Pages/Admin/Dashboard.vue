<template>
    <Head title="Dashboard" />

    <admin-layout
    >
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>
        <div class="pt-5">
            <span class="text-base font-bold text-black"
                >Summary Statistics</span
            >
            <div
                class="flex flex-col pt-5 space-y-4 md:flex-row md:space-y-0 md:space-x-8"
            ></div>
        </div>
    </admin-layout>
</template>

<script>
import { ref } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";

export default {
    name: "DashboardIndex",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
    },
    setup() {

    },
};
</script>
