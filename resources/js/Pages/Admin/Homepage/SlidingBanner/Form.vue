<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4">
            <div
                class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            >
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Title <span class="text-red-400">*</span></span
                    >
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.title,
                        }"
                        v-model="form.title"
                        :disabled="form.processing"
                        maxlength="64"
                    />
                    <span
                        v-if="form.errors.title"
                        class="text-red-400 italic"
                        >{{ form.errors.title }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Subtitle <span class="text-red-400">*</span></span
                    >
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.subtitle,
                        }"
                        v-model="form.subtitle"
                        :disabled="form.processing"
                        maxlength="134"
                    />
                    <span
                        v-if="form.errors.subtitle"
                        class="text-red-400 italic"
                        >{{ form.errors.subtitle }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Button Text</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.button_text,
                        }"
                        v-model="form.button_text"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.button_text"
                        class="text-red-400 italic"
                        >{{ form.errors.button_text }}</span
                    >
                </div>
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Button Link</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.button_link,
                        }"
                        v-model="form.button_link"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.button_link"
                        class="text-red-400 italic"
                        >{{ form.errors.button_link }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Banner Desktop
                        <span v-if="!banner" class="text-red-400">*</span></span
                    >
                    <input
                        type="file"
                        accept="image/jpg,image/jpeg,image/png,video/mp4"
                        :class="{
                            'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.desktop_banner,
                        }"
                        @change="onDesktopBannerChange($event)"
                        :disabled="form.processing"
                    />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <a
                        v-if="banner && banner.desktop_banner.indexOf('.mp4') >= 0"
                        class="py-3 px-6 w-1/2 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                        :href="desktop_banner_path"
                        target="_blank"
                        :disabled="form.processing"
                    >
                        See Video
                    </a>
                    <preview-image v-else :src="desktop_banner_path" />
                    <span
                        v-if="form.errors.desktop_banner"
                        class="text-red-400 italic"
                        >{{ form.errors.desktop_banner }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Banner Mobile
                        <span v-if="!banner" class="text-red-400">*</span></span
                    >
                    <input
                        type="file"
                        accept="image/jpg,image/jpeg,image/png,video/mp4"
                        :class="{
                            'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.mobile_banner,
                        }"
                        @change="onMobileBannerChange($event)"
                        :disabled="form.processing"
                    />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <a
                        v-if="banner && banner.mobile_banner.indexOf('.mp4') >= 0"
                        class="py-3 px-6 w-1/2 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                        :href="mobile_banner_path"
                        target="_blank"
                        :disabled="form.processing"
                    >
                        See Video
                    </a>
                    <preview-image v-else :src="mobile_banner_path" />

                    <span
                        v-if="form.errors.mobile_banner"
                        class="text-red-400 italic"
                        >{{ form.errors.mobile_banner }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Banner Type <span class="text-red-400">*</span></span
                    >
                    <select-search
                        clearable
                        disable-search
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.tipe,
                        }"
                        v-model="form.tipe"
                        :disabled="form.processing"
                        :options="typeOptions"
                    >
                    </select-search>
                    <span
                        v-if="form.errors.tipe"
                        class="text-red-400 italic"
                        >{{ form.errors.tipe }}</span
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

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.homepage.sliding-banner.index')"
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
import TextEditor from "@/Components/Input/TextEditor.vue";

export default {
    name: "MasterKaryawanForm",
    components: {
        SelectSearch,
        InputPassword,
        InputDate,
        InputPhoneNumber,
        PreviewImage,
        Link,
        TextEditor,
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
        banner: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({
            title: "",
            subtitle: "",
            button_text: "",
            button_link: "",
            desktop_banner: "",
            mobile_banner: "",
            status: "",
            tipe: "",
        });

        const desktop_banner_path = ref("");
        const mobile_banner_path = ref("");

        onMounted(() => {
            if (props.banner) {
                form.status = props.banner.status ? '1' : '0';

                form.title = props.banner.title;
                form.subtitle = props.banner.subtitle;
                form.button_text = props.banner.button_text;
                form.button_link = props.banner.button_link;
                form.tipe = props.banner.tipe;

                desktop_banner_path.value = props.banner.desktop_banner;
                mobile_banner_path.value = props.banner.mobile_banner;
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                desktop_banner: form.desktop_banner,
                mobile_banner: form.mobile_banner,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        const allowedImages = [
            'image/jpg',
            'image/jpeg',
            'image/png',
        ]

        function onDesktopBannerChange(evt) {
            let files = evt.target.files || evt.dataTransfer.files;

            if (!files.length) return;

            form.desktop_banner = files[0];
            desktop_banner_path.value = "";

            if (allowedImages.includes(files[0].type)) {
                desktop_banner_path.value = URL.createObjectURL(files[0]);
            }
        }

        function onMobileBannerChange(evt) {
            let files = evt.target.files || evt.dataTransfer.files;

            if (!files.length) return;

            form.mobile_banner = files[0];
            mobile_banner_path.value = "";

            if (allowedImages.includes(files[0].type)) {
                mobile_banner_path.value = URL.createObjectURL(files[0]);
            }
        }

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

        const typeOptions = ref([
            {
                label: "Main Banner",
                value: "main_banner",
            },
            {
                label: "Secondary Banner",
                value: "secondary_banner",
            },
        ]);

        return {
            form,
            desktop_banner_path,
            mobile_banner_path,
            submit,
            onDesktopBannerChange,
            onMobileBannerChange,
            statusOptions,
            typeOptions,
        };
    },
};
</script>
