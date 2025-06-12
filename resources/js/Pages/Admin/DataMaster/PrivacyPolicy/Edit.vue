<template>
    <Head title="Privacy Policy" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Edit Privacy Policy
            </h2>
        </template>

        <privacy-policy-form
            http-method="put"
            :action-uri="
                route('admin.privacy-policy.update', [policy.id])
            "
            :policy="policy"
            :jabatan="jabatan"
        />
    </admin-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import PrivacyPolicyForm from "@/Pages/Admin/DataMaster/PrivacyPolicy/Form.vue";

export default {
    name: "PrivacyPolicyEdit",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        PrivacyPolicyForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
        policy: {
            type: Object,
            default: () => null,
        },
    },
};
</script>