<template>
    <form @submit.prevent="submit()">
        <div class="flex justify-center">
            <draggable class="w-100" :list="list">
                <div
                    class="w-[20rem] text-white font-semibold bg-blue-600 focus:bg-blue-300 m-1 p-3 rounded-md text-center cursor-pointer shadow my-2"
                    v-for="element in list"
                    :key="element.name"
                >
                    <p class="text-center">
                        {{ element.name }}
                    </p>
                </div>
            </draggable>
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

import { VueDraggableNext } from 'vue-draggable-next'

export default {
    name: "SlidingBannerPosition",
    components: {
        SelectSearch,
        InputPassword,
        InputDate,
        InputPhoneNumber,
        PreviewImage,
        Link,
        draggable: VueDraggableNext,
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
        slidingBanner: {
            type: Object,
            default: () => null,
        }
    },
    setup(props) {
        
        let list = ref(props.slidingBanner);
        
        const form = useForm({
            list:list
        });

        onMounted(() => {
        
        });


        function submit() {
            form.transform((data) => ({
                ...data,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        const dragging = false;

        return {
            form,
            submit,
            list,
            dragging,
        };
    },
};
</script>
