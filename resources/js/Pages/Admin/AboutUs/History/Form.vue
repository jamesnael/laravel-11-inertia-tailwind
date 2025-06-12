<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4">
            <div class="flex-1 flex flex-col space-y-2">
                <span class="text-black font-medium">Year <span class="text-red-400">*</span></span
                >
                <input
                    type="text"
                    :class="{
                        'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        'border-red-400': form.errors.year,
                    }"
                    v-model="form.year"
                    :disabled="form.processing"
                />
                <span
                    v-if="form.errors.year"
                    class="text-red-400 italic"
                    >{{ form.errors.year }}</span
                >
            </div>

            <div class="flex-1 flex flex-col space-y-2">
                <span class="text-black font-medium"
                    >Description <span class="text-red-400">*</span></span
                >
                <textarea
                    rows="5"
                    :class="{
                        'w-full rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        'border-red-400': form.errors.description,
                    }"
                    v-model="form.description"
                    :disabled="form.processing"
                />
                <span
                    v-if="form.errors.description"
                    class="text-red-400 italic"
                    >{{ form.errors.description }}</span
                >
            </div>

            <div
                class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            >
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Image
                        <span class="text-red-400">*</span></span
                    >
                    <preview-image :src="image_path" />
                    <input
                        type="file"
                        accept="image/*"
                        :class="{
                            'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.images,
                        }"
                        @change="onFileChange($event)"
                        :disabled="form.processing"
                    />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <span
                        v-if="form.errors.images"
                        class="text-red-400 italic"
                        >{{ form.errors.images }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Image Source <span class="text-red-400">*</span></span
                    >
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.image_source,
                        }"
                        v-model="form.image_source"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.image_source"
                        class="text-red-400 italic"
                        >{{ form.errors.image_source }}</span
                    >
                </div>
            </div>  

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.about-us.history.index')"
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
import { ref, onMounted, computed } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import SelectSearch from "@/Components/Select/SelectSearch.vue";
import InputPassword from "@/Components/Input/Password.vue";
import InputDate from "@/Components/Input/Date.vue";
import InputPhoneNumber from "@/Components/Input/PhoneNumber.vue";
import PreviewImage from "@/Components/Image/Preview.vue";

export default {
    name: "OurTeamCategoryForm",
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
        history: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({
            year: "",
            description: "",
            image_source: "",
            images:"",
        });

        const image_path = ref("");

        onMounted(() => {
            if (props.history) {
                form.year = props.history.year;
                form.description = props.history.description;
                form.image_source = props.history.image_source;
                form.images = props.history.image;
                image_path.value = props.history.image;
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        function onFileChange(evt) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.images = files[0];
            image_path.value = URL.createObjectURL(files[0]);
        }

        return {
            form,
            image_path,
            submit,
            onFileChange,
        };
    },
};
</script>
