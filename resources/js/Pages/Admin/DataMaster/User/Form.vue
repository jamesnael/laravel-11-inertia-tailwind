<template>
	<form @submit.prevent="submit()">
		<div class="flex flex-col space-y-4">
			<div
			  class="grid grid-cols-1 md:grid-cols-2 gap-4"
			>
			  <div class="flex flex-col space-y-2">
				  <span class="font-medium text-black"
					  >Nama Lengkap <span class="text-red-400">*</span></span
				  >
				  <input
					  type="text"
					  :class="{
						  'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						  'border-red-400': form.errors.nama_lengkap,
					  }"
					  v-model="form.nama_lengkap"
					  :disabled="form.processing"
				  />
				  <span
					  v-if="form.errors.nama_lengkap"
					  class="italic text-red-400"
					  >{{ form.errors.nama_lengkap }}</span
				  >
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
					>Role <span class="text-red-400">*</span></span
				>
				<select-search
					clearable
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.id_jabatan,
					}"
					v-model="form.id_jabatan"
					:disabled="form.processing"
					:options="role"
				>
				</select-search>
				<span
					v-if="form.errors.id_jabatan"
					class="italic text-red-400"
					>{{ form.errors.id_jabatan }}</span
				>
				<input type="hidden" v-model="showJabatanLabel" />
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
					>Alamat Email <span class="text-red-400">*</span></span
				>
				<input
					type="email"
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.email,
					}"
					v-model="form.email"
					:disabled="form.processing"
				/>
				<span
					v-if="form.errors.email"
					class="italic text-red-400"
					>{{ form.errors.email }}</span
				>
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
					>Username <span class="text-red-400">*</span></span
				>
				<input
					type="text"
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.username,
					}"
					autocomplete="new-username"
					v-model="form.username"
					:disabled="form.processing"
				/>
				<span
					v-if="form.errors.username"
					class="italic text-red-400"
					>{{ form.errors.username }}</span
				>
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
				  >Password
				  <span v-if="!user" class="text-red-400"
					  >*</span
				  ></span
				>
				<input-password
				  :class="{
					  'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
					  'border-red-400': form.errors.password,
				  }"
				  v-model="form.password"
				  :disabled="form.processing"
				/>
				<span v-if="user" class="text-xs italic text-black"
					>Biarkan kosong jika tidak ingin mengubah password</span
				>
				<span
					v-if="form.errors.password"
					class="italic text-red-400"
					>{{ form.errors.password }}</span
				>
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
				  >Konfirmasi Password
				  <span v-if="!user" class="text-red-400"
					  >*</span
				  ></span
				>
				<input-password
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.password_confirmation,
					}"
					v-model="form.password_confirmation"
					:disabled="form.processing"
				/>
				<span v-if="user" class="text-xs italic text-black"
					>Biarkan kosong jika tidak ingin mengubah password</span
				>
				<span
					v-if="form.errors.password_confirmation"
					class="italic text-red-400"
					>{{ form.errors.password_confirmation }}</span
				>
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
					>Nomor HP <span class="text-red-400">*</span></span
				>
				<input-phone-number
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.nomor_hp,
					}"
					v-model="form.nomor_hp"
					:disabled="form.processing"
				/>
				<span
					v-if="form.errors.nomor_hp"
					class="italic text-red-400"
					>{{ form.errors.nomor_hp }}</span
				>
			  </div>

			  <div class="flex flex-col space-y-2">
				<span class="font-medium text-black"
					>Status <span class="text-red-400">*</span></span
				>
				<select-search
					clearable
					disable-search
					:class="{
						'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
						'border-red-400': form.errors.status,
					}"
					v-model="form.status"
					:disabled="form.processing"
					:options="statusOptions"
				>
				</select-search>
				<span
					v-if="form.errors.status"
					class="italic text-red-400"
					>{{ form.errors.status }}</span
				>
			  </div>
			</div>

			<div class="flex flex-row justify-end space-x-4 mt-10">
				<Link
				  class="px-6 py-3 font-semibold text-center text-white bg-gray-400 rounded-md shadow-md focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
				  :href="route('admin.data-master.user.index')"
				  :disabled="form.processing"
				>
				  Kembali
				</Link>
				<button
				  type="submit"
				  class="px-6 py-3 font-semibold text-center text-white bg-blue-500 rounded-md shadow-md focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
				  :disabled="form.processing"
				>
				  Simpan
				</button>
			</div>
		</div>
	</form>
</template>

<script setup>
	import { ref, onMounted, computed, watch } from "vue";
	import { useForm, Link } from "@inertiajs/inertia-vue3";
	import SelectSearch from "@/Components/Select/SelectSearch.vue";
	import InputPassword from "@/Components/Input/Password.vue";
	import InputDate from "@/Components/Input/Date.vue";
	import InputPhoneNumber from "@/Components/Input/PhoneNumber.vue";
	import PreviewImage from "@/Components/Image/Preview.vue";

	const props = defineProps({
		httpMethod: {
			type: String,
			default: () => "post",
			validator(value) {
				return ["get", "post", "put", "patch", "delete"].includes(
					value
				);
			},
		},
		actionUri: {
			type: String,
			default: () => "",
		},
		jabatanUri: {
			type: String,
			default: () => "",
		},
		user: {
			type: Object,
			default: () => null,
		},
		role: {
			type: Array,
			default: () => [],
		}
	});

	const statusOptions = ref([
		{
			label: "Aktif",
			value: "1",
		},
		{
			label: "Tidak Aktif",
			value: "0",
		},
	]);

	const form = useForm({
		nama_lengkap: "",
		nomor_hp: "",
		username: "",
		email: "",
		password: "",
		password_confirmation: "",
		alamat_lengkap: "",
		id_jabatan: "",
		status: "",
	});

	onMounted(() => {
		if (props.user) {
		  form.nama_lengkap = props.user.nama_lengkap;
		  form.nomor_hp = props.user.nomor_hp;
		  form.username = props.user.username;
		  form.email = props.user.email;
		  form.password = "";
		  form.password_confirmation = "";
		  form.alamat_lengkap = props.user.alamat_lengkap;

		  form.status = props.user.status ? "1" : "0";

		  setTimeout(() => {
			form.id_jabatan = _.toString(props.user.id_jabatan);
		  }, 100);
		}
	});

	const showJabatanLabel = computed(() => {
		if (form.id_jabatan) {
			let data = _.filter(
				props.role,
				(role) => role.value == form.id_jabatan
			);
			return data[0].tipe_user;
		}
	});

	function submit() {
		form.transform((data) => ({
			...data,
			ektp: form.ektp,
			_method: props.httpMethod,
		})).post(props.actionUri);
	}

	watch(() => form.id_jabatan, (newVal) => {
	  const selected = props.role.filter(item => {
		return parseInt(item.value) === parseInt(newVal)
	  })
	})
</script>
