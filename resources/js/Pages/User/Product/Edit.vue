<template>
    <Head title="Product" />

    <admin-layout>
        <template #breadcrumbs>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
        </template>

        <template #page-title>
            <h2 class="text-dark-7 text-lg font-medium mr-auto pb-5">
                Edit Product
            </h2>
        </template>

        <product-form
            http-method="put"
            :action-uri="
                route('user.product.update', [
                    product.slug,
                ])
            "
            :product="product"
            :categories="categories"
            :sub-categories="sub_categories"
            :country-options="countryOptions"
            :company-options="companyOptions"
            :paragraph="paragraph"
            :table="table"
            :media="media"
            :quote="quote"
            :faq="faq"
            :reference="reference"
            :history="history"
            :data_related_files="data_related_files"
        />
    </admin-layout>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Layouts/Breadcrumb.vue";
import ProductForm from "@/Pages/User/Product/Form.vue";

export default {
    name: "MasterAdminProductEdit",
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
        product: {
            type: Object,
            default: () => null,
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
        },
        paragraph: {
            type: Object,
            default: () => null,
        },
        table: {
            type: Object,
            default: () => null,
        },
        media: {
            type: Object,
            default: () => null,
        },
        quote: {
            type: Object,
            default: () => null,
        },
        faq: {
            type: Object,
            default: () => null,
        },
        reference: {
            type: Object,
            default: () => null,
        },
        history: {
            type: Object,
            default: () => null,
        },
        data_related_files: {
            type: Array,
            default: () => [],
        },
    },
};
</script>
