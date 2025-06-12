<template>
    <Head title="Privacy Policy" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto">
                Data Privacy Policy
            </h2>
        </template>

        <h2 class="text-3xl font-semibold">{{ form.title }}</h2>

        <div class="flex flex-col gap-2 mt-4" v-html="form.content"></div>

        <div class="flex flex-row space-x-4 mt-4">
            <Link
                v-if="
                    hasAccess(
                        'module.privacy-policy.edit',
                        $page.props.currentUser.jabatan.hak_akses
                    )
                "
                :href="
                    route('admin.privacy-policy.edit', {
                        policy: form.id,
                    })
                "
                class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
            >
                Edit Data
            </Link>
        </div>
    </admin-layout>
</template>

<script>
import { ref } from "vue";
import { Head, Link, usePage, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";

export default {
    name: "PrivacyPolicyIndex",
    components: {
        Head,
        Link,
        AdminLayout,
        Breadcrumb,
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
    setup(props) {
        const form = useForm({});

        if (props.policy) {
            form.id = props.policy.id;
            form.title = props.policy.title;
            form.content = props.policy.content;
        }

        return {
            form,
        };
    },
};
</script>