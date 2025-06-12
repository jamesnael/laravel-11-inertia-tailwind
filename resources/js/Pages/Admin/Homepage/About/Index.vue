<template>
    <Head title="About" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto">
                Data About
            </h2>
        </template>

        <h2 class="text-dark-7 text-lg font-medium mr-auto">
            Left Text
        </h2>
        <div class="flex flex-col gap-2" v-html="form.left_text"></div>

        <h2 class="text-dark-7 text-lg font-medium mr-auto mt-3" v-if="form.left_button_label">
            Left Button Label
        </h2>
        <div class="flex flex-col gap-2" v-html="form.left_button_label"></div>

        <h2 class="text-dark-7 text-lg font-medium mr-auto mt-3" v-if="form.left_button_link">
            Left Button Link
        </h2>
        <div class="flex flex-col gap-2" v-html="form.left_button_link"></div>

        <h2 class="text-dark-7 text-lg font-medium mr-auto mt-3">
            Right Text
        </h2>
        <div class="flex flex-col gap-2" v-html="form.right_text"></div>

        <h2 class="text-dark-7 text-lg font-medium mr-auto mt-3" v-if="form.right_button_label">
            Right Button Label
        </h2>
        <div class="flex flex-col gap-2" v-html="form.right_button_label"></div>
        
        <h2 class="text-dark-7 text-lg font-medium mr-auto mt-3" v-if="form.right_button_link">
            Right Button Link
        </h2>
        <div class="flex flex-col gap-2" v-html="form.right_button_link"></div>

        <div class="flex flex-row space-x-4 mt-4">
            <Link
                v-if="
                    hasAccess(
                        'module.homepage.home-about.edit',
                        $page.props.currentUser.jabatan.hak_akses
                    )
                "
                :href="
                    route('admin.homepage.home-about.edit', {
                        home_about: form.id,
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
    name: "HomeAboutIndex",
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
        homeabout: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({});

        if (props.homeabout) {
            form.id = props.homeabout.id;
            form.left_text = props.homeabout.left_text;
            form.left_button_label = props.homeabout.left_button_label;
            form.left_button_link = props.homeabout.left_button_link;
            form.right_text = props.homeabout.right_text;
            form.right_button_label = props.homeabout.right_button_label;
            form.right_button_link = props.homeabout.right_button_link;
        }

        return {
            form,
        };
    },
};
</script>
