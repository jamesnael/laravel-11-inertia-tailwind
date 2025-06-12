<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="w-6/12 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Page Name <span class="text-red-400">*</span>
                    </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.page_name,
                        }"
                        v-model="form.page_name"
                        :disabled="form.processing"
                        readonly
                    />
                    <span v-if="form.errors.page_name" class="text-red-400 italic">{{
                        form.errors.page_name
                    }}</span>
                </div>
       
                <div class="w-6/12 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Meta Title <span class="text-red-400">*</span>
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
                    <span v-if="form.errors.title" class="text-red-400 italic">{{
                        form.errors.title
                    }}</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="w-6/12 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Route Slug <span class="text-red-400">*</span>
                    </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.route_slug,
                        }"
                        v-model="form.route_slug"
                        :disabled="form.processing"
                    />
                    <span v-if="form.errors.route_slug" class="text-red-400 italic">{{
                        form.errors.route_slug
                    }}</span>
                </div>
       
                <div class="w-6/12 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Controller Name <span class="text-red-400">*</span>
                    </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.controller_name,
                        }"
                        v-model="form.controller_name"
                        :disabled="true"
                        readonly
                    />
                    <span v-if="form.errors.controller_name" class="text-red-400 italic">{{
                        form.errors.controller_name
                    }}</span>
                </div>
            </div>

            <div class="w-6/12 flex flex-col space-y-2">
                <span class="text-black font-medium">
                    Route Name <span class="text-red-400">*</span>
                </span>
                <input
                    type="text"
                    :class="{
                        'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        'border-red-400': form.errors.slug,
                    }"
                    :value="form.slug"
                    :disabled="true"
                    readonly
                />
                <span v-if="form.errors.slug" class="text-red-400 italic">{{
                    form.errors.slug
                }}</span>
            </div>

            <div
                class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8"
            >
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Meta Description
                        <span class="text-red-400">*</span>
                    </span>
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
            </div>

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.updates.author.index')"
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
import { onMounted, ref } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";


export default {
    name: "MetaForm",
    components: {
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
        meta: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({
            page_name: "",
            description: "",
            title: "",
            controller_name: "",
            route_slug: ""
        });

        onMounted(() => {
            if (props.meta) {
                form.page_name = props.meta.page_name;
                form.description = props.meta.description;
                form.title = props.meta.title;
                form.controller_name = props.meta.controller_name;
                form.route_slug = props.meta.route_slug;
                form.slug = props.meta.slug;
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        return {
            form,
            submit,
        };
    },
};
</script>
