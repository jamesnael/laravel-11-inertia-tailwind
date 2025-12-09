<template>
	<Head title="User" />

	<admin-layout>
		<template #breadcrumbs>
			<Breadcrumb :breadcrumbs="breadcrumbs" />
		</template>

		<template #page-title>
			<h2 class="pb-5 mr-auto text-lg font-medium text-dark-7">
				Tambah User
			</h2>
		</template>

		<user-form
			http-method="post"
			:action-uri="route('admin.data-master.user.store')"
			:role-uri="route('admin.data-master.user.role')"
			:role="role"
		/>
	</admin-layout>
</template>

<script setup>
	import { Head, useForm } from "@inertiajs/inertia-vue3";
	import AdminLayout from "@/Layouts/AdminLayout.vue";
	import Breadcrumb from "@/Layouts/Breadcrumb.vue";
	import UserForm from "@/Pages/Admin/DataMaster/User/Form.vue";

	defineProps({
		breadcrumbs: {
			type: Array,
		},
		role: {
			type: Array,
			default: () => [],
		}
	});
</script>
