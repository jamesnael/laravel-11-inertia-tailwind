<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4">
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

            <div class="h-auto flex flex-col">
                <span class="text-black font-medium">
                    Content
                </span>
                <!-- <quill-editor
                    theme="snow"
                    contentType="html"
                    v-model:content="form.content"
                    toolbar="essential"
                    :disabled="form.processing"
                ></quill-editor> -->
                <text-editor v-model="form.content"/>

                <span
                    v-if="form.errors.content"
                    class="text-red-400 italic"
                    >{{ form.errors.content }}</span
                >
            </div>

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.privacy-policy.index')"
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
import { onMounted } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import TextEditor from "@/Components/Input/TextEditor.vue";

export default {
    name: "PrivacyPolicyForm",
    components: {
        Link,
        TextEditor
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
        policy: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const form = useForm({
            id: "",
            title: "",
            content: "",
        });

        onMounted(() => {
            if (props.policy) {
                form.id = props.policy.id;
                form.title = props.policy.title;
                form.content = props.policy.content;
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
