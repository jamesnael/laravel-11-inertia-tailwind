<template>
    <form @submit.prevent="submit()">
        <div class="h-auto flex flex-col space-y-4 mt-3">
            <div class="h-auto flex md:space-x-8">
                <div class="flex-1 flex flex-col">
                <span class="text-black font-medium">Left Text <span class="text-red-400">*</span></span>
                <text-editor v-model="form.left_text" :fontstyleonly="true"/>
                <span v-if="form.errors.left_text" class="text-red-400 italic">{{ form.errors.left_text }}</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Left Button Label</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.left_button_label,
                        }"
                        v-model="form.left_button_label"
                        :disabled="form.processing"
                    />
                    <span v-if="form.errors.left_button_label" class="text-red-400 italic">{{ form.errors.left_button_label }}</span>
                    <small>Leave the field blank if you don't want to use the button</small>
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Left Button Link</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.left_button_link,
                        }"
                        v-model="form.left_button_link"
                        :disabled="form.processing"
                    />
                    <span v-if="form.errors.right_button_label" class="text-red-400 italic">{{ form.errors.right_button_label }}</span>
                    <small>Leave the field blank if you don't want to use the button</small>
                </div>
            </div>  

            <div class="h-auto flex md:space-x-8">
                <div class="flex-1 flex flex-col">
                <span class="text-black font-medium">Right Text <span class="text-red-400">*</span></span>
                <text-editor v-model="form.right_text" :fontstyleonly="true"/>
                <span v-if="form.errors.right_text" class="text-red-400 italic">{{ form.errors.right_text }}</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Right Button Label</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.right_button_label,
                        }"
                        v-model="form.right_button_label"
                        :disabled="form.processing"
                    />
                    <span v-if="form.errors.right_button_label" class="text-red-400 italic">{{ form.errors.right_button_label }}</span>
                    <small>Leave the field blank if you don't want to use the button</small>
                    </div>
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Right Button Link</span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.right_button_link,
                        }"
                        v-model="form.right_button_link"
                        :disabled="form.processing"
                    />
                    <span v-if="form.errors.right_button_link" class="text-red-400 italic">{{ form.errors.right_button_link }}</span>
                    <small>Leave the field blank if you don't want to use the button</small>
                    </div>
                </div>
            </div>  

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('admin.homepage.home-about.index')"
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
import TextEditor from "@/Components/Input/TextEditor.vue";

export default {
    name: "AboutForm",
    components: {
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
        homeabout: {
            type: Object,
            default: () => null,
        },
    },
    setup(props) {
        const image_path = ref("");

        const form = useForm({
            id:'',
            left_text:'',
            left_button_label:'',
            left_button_link:'',
            right_text:'',
            right_button_label:'',
            right_button_link:'',
        });

        onMounted(() => {
            if (props.homeabout) {
                form.id = props.homeabout.id;
                form.left_text = props.homeabout.left_text;
                form.left_button_label = props.homeabout.left_button_label;
                form.left_button_link = props.homeabout.left_button_link;
                form.right_text = props.homeabout.right_text;
                form.right_button_label = props.homeabout.right_button_label;
                form.right_button_link = props.homeabout.right_button_link;
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        function tambahObjective() {
          form.objective.push({
            title:'',
            description:'',
          })
        }

        function deleteObjective(idx) {
            form.objective = _.filter(form.objective, (el, key) => {
                return key != idx
            })
        }

        return {
            deleteObjective,
            tambahObjective,
            form,
            submit,
        };
    },
};
</script>
