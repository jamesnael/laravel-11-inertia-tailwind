<template>
    <Head title="Product" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Create Product
            </h2>
        </template>

        <product-form
            http-method="post"
            :action-uri="route('user.product.store')"
            :categories="categories"
            :sub-categories="sub_categories"
            :country-options="countryOptions"
            :company-options="companyOptions"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import ProductForm from "@/Pages/User/Product/Form.vue";

export default {
    name: "MasterProductCreate",
    components: {
        Head,
        AdminLayout,
        Breadcrumb,
        ProductForm,
    },
    props: {
        breadcrumbs: {
            type: Array,
        },
        categories: {
            type: Array
        },
        sub_categories: {
            type: Array
        },
        countryOptions: {
            type: Array
        },
        companyOptions: {
            type: Array
        }
    },
};
</script>
