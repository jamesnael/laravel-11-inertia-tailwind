<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4">
            <div
                class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            >
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Title <span class="text-red-400">*</span>
                    </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.title,
                        }"
                        v-model="form.title"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.title"
                        class="text-red-400 italic"
                        >{{ form.errors.title }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
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
                        class="text-red-400 italic"
                        >{{ form.errors.status }}</span
                    >
                </div>
            </div>

            <div
                class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            >
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Logo Image
                        <span v-if="!partner_logo" class="text-red-400">*</span></span
                    >
                    <input
                        type="file"
                        accept="image/*"
                        :class="{
                            'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.image,
                        }"
                        @change="onImageChange($event)"
                        :disabled="form.processing"
                    />
                    <preview-image :src="image_path" />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <span
                        v-if="form.errors.image"
                        class="text-red-400 italic"
                        >{{ form.errors.image }}</span
                    >
                </div>
            </div>

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.homepage.supported-by.index')"
                    :disabled="form.processing"
                >
                    Back
                </Link>
                <button
                    type="submit"
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
                    :disabled="form.processing"
                >
                    Save
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import { ref, onMounted } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import SelectSearch from "@/Components/Select/SelectSearch.vue";
import InputPassword from "@/Components/Input/Password.vue";
import InputDate from "@/Components/Input/Date.vue";
import InputPhoneNumber from "@/Components/Input/PhoneNumber.vue";
import PreviewImage from "@/Components/Image/Preview.vue";

export default {
    name: "SupportedByForms",
    components: {
        SelectSearch,
        InputPassword,
        InputDate,
        InputPhoneNumber,
        PreviewImage,
        Link,
    },
    props: {
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
        supported_by: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({
            title: "",
            image: "",
            status: "",
        });

        const statusOptions = ref([
            {
                label: "Publish",
                value: "1",
            },
            {
                label: "Unpublish",
                value: "0",
            },
        ]);

        const image_path = ref("");

        onMounted(() => {
            if (props.supported_by) {
                form.title = props.supported_by.title;
                form.status = props.supported_by.status ? "1" : "0";

                image_path.value = props.supported_by.image;
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                image: form.image,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        function onImageChange(evt) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.image = files[0];
            image_path.value = URL.createObjectURL(files[0]);
        }

        return {
            form,
            image_path,
            submit,
            onImageChange,
            statusOptions,
        };
    },
};
</script>
