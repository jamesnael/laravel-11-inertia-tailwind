<template>
    <Head title="Dashboard" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>
        <div class="pt-5">
            <span class="text-black font-bold text-base">Summary Statistics</span
            >
            <div
                class="flex flex-col pt-5 md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            ></div>
        </div>
    </admin-layout>
</template>

<script>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import DialogModal from "@/Components/Modal/DialogModal.vue";

export default {
    name: "TransaksiPenagihanIndex",
    components: {
        Head,
        Link,
        AdminLayout,
        Breadcrumb,
        DialogModal,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
        customer: {
            type: Number,
        },
        sales: {
            type: Number,
        },
        collector: {
            type: Number,
        },
        totalPenjualan: {
            type: Number,
        },
        totalPembayaran: {
            type: Number,
        },
    },
};
</script>
