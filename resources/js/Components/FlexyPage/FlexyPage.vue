<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4 mt-3">
            
            <div class="flex md:space-x-8" v-if="withTitle">
                <div class="flex-1 flex flex-col space-y-1">
                <span class="text-black font-medium">Title <span class="text-red-400">*</span></span>
                <input type="text" :class="{ 'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.title }" v-model="form.title" :disabled="form.processing">
                <span v-if="form.errors.title" class="text-red-400 italic">{{ form.errors.title }}</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8" v-if="withCountry">
                <div class="flex-1 flex flex-col space-y-1">
                    <span class="text-black font-medium"
                        >Country <span class="text-red-400">*</span></span
                    >
                    <select-search
                        clearable
                        disable-search
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.country_id,
                        }"
                        v-model="form.country_id"
                        :options="countryOptions"
                    >
                    </select-search>
                    <span v-if="form.errors.country_id" class="text-red-400 italic">{{ form.errors.country_id }}</span
                    >
                </div>

                <div class="flex-1"></div>
            </div>

            <p class="text-red-500">Drag and drop the content to change position</p>

            <draggable class="w-100" :list="form.section">
                <div v-for="(el, idx) in form.section">
                    <details open>
                        <summary>
                            <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-2 rounded-md text-center cursor-pointer shadow">
                                <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                                    <button type="button" class="appearance-none outline-none focus:border-transparent focus:outline-none bg-transparent" title="Drag">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.2 9l-3 3 3 3M9 5.2l3-3 3 3M15 18.9l-3 3-3-3M18.9 9l3 3-3 3M3.3 12h17.4M12 3.2v17.6"/></svg>
                                    </button>                            
                                </div>
                                <div class="flex-1 flex flex-col space-y-1 text-right">
                                    <span class="font-medium text-lg">{{ el.position ?? el.number }}. {{ el.tipe }} </span>
                                </div>
                                <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                                    <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteSetion(idx)" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                            </div>
                        </summary>


                        <div class="px-6 space-y-1">
                            <template v-if="el.tipe == 'Paragraph'">
                                <div class="flex">
                                    <div class="flex-1 flex flex-col space-y-1 mr-3">
                                        <span class="text-black font-medium">Title</span>
                                        <input type="text" :class="{ 'text-sm p-[7px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.title }" v-model="el.title" :disabled="form.processing">
                                        <span v-if="form.errors.title" class="text-red-400 italic">{{ form.errors.title }}</span>
                                    </div>
                                    <div class="flex-1 flex flex-col space-y-1">
                                        <span class="text-black font-medium">Title Size</span>
                                        <select-search
                                            clearable
                                            :class="{
                                                'text-sm p-[7px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                                'border-red-400': form.errors.title_size,
                                            }"
                                            v-model="el.title_size"
                                            :disabled="form.processing"
                                            :options="sizeOptions"
                                        >
                                        </select-search>
                                        <span v-if="form.errors.title_size" class="text-red-400 italic">{{ form.errors.title_size }}</span>
                                    </div>
                                </div>


                                <div class="flex-1 flex flex-col">
                                    <span class="text-black font-medium mb-2">Content</span>
                                    <text-editor v-model="el.content"/>
                                    <span v-if="form.errors.content" class="text-red-400 italic">{{ form.errors.content }}</span>
                                </div>

                                <div v-for="(val, key) in el.detail" class="px-5 pt-3">
                                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-2 rounded-md text-center  shadow my-2">
                                        <div class="flex-1 flex flex-col space-y-1">
                                            <span class="text-black font-medium text-md">Item {{key+1}}</span>
                                        </div>
                                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteDetail(idx,key)" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="flex">
                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Title</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.title }" v-model="val.title" :disabled="form.processing">
                                            <span v-if="form.errors.title" class="text-red-400 italic">{{ form.errors.title }}</span>
                                        </div>

                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Description</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.description }" v-model="val.description" :disabled="form.processing">
                                            <span v-if="form.errors.description" class="text-red-400 italic">{{ form.errors.description }}</span>
                                        </div>

                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">
                                                Icon
                                            </span>
                                            <input
                                                type="file"
                                                accept="image/*"
                                                :class="{
                                                    'text-sm p-[2px] rounded-md border focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                                    'border-red-400': form.errors.icons,
                                                }"
                                                @change="onFileChangeDetailParagraph($event,idx,key)"
                                                :disabled="form.processing"
                                            />
                                            <preview-image :src="val.image_path" />
                                            <progress
                                                v-if="form.progress"
                                                :value="form.progress.percentage"
                                                max="100"
                                            >
                                                {{ form.progress.percentage }}%
                                            </progress>
                                        </div>
                                    </div>
                                    
                                    <div class="flex">
                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Button Label</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.button_label }" v-model="val.button_label" :disabled="form.processing">
                                            <span v-if="form.errors.button_label" class="text-red-400 italic">{{ form.errors.button_label }}</span>
                                        </div>

                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Button URL</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.button_url }" v-model="val.button_url" :disabled="form.processing">
                                            <span v-if="form.errors.button_url" class="text-red-400 italic">{{ form.errors.button_url }}</span>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="pt-[1rem] pb-[1rem]">
                                    <a style="cursor:pointer" class="py-3 px-6 mt-4 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing" @click="addDetailParagraph(idx)">
                                        + Add Item
                                    </a>
                                </div>
                            </template>

                            <template v-if="el.tipe == 'Table'">
                                <div class="flex-1 flex flex-col mr-5">
                                    <span class="text-black font-medium mb-2">Content</span>
                                    <text-editor v-model="el.content" :tableonly="true"/>
                                    <span v-if="form.errors.content" class="text-red-400 italic">{{ form.errors.content }}</span>
                                </div>
                            </template>

                            <template v-if="el.tipe == 'Image'">
                                <div class="flex space-x-2">
                                    <div class="flex-1 flex flex-col">
                                        <span class="text-black font-medium">
                                            Image
                                        </span>
                                        <small>Recommended Image Size : 1280 x 720</small>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            :class="{
                                                'p-[2px] mb-3 rounded-md border focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                                'border-red-400': form.errors.images,
                                            }"
                                            @change="onFileChangeDetail($event,idx)"
                                            :disabled="form.processing"
                                        />
                                        <preview-image :src="el.image_path" />
                                        <progress
                                            v-if="form.progress"
                                            :value="form.progress.percentage"
                                            max="100"
                                        >
                                            {{ form.progress.percentage }}%
                                        </progress>
                                    </div>

                                    <div class="flex-1 flex flex-col space-y-5">
                                        <span class="text-black font-medium">Source</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.source }" v-model="el.source" :disabled="form.processing">

                                        <span v-if="form.errors.source" class="text-red-400 italic">{{ form.errors.source }}</span>
                                    </div>
                                </div>
                            </template>

                            <template v-if="el.tipe == 'Video'">
                                <div class="flex">
                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Video (URL)</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.video }" v-model="el.video" :disabled="form.processing" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ">

                                        <span v-if="form.errors.video" class="text-red-400 italic">{{ form.errors.video }}</span>
                                    </div>

                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Title</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.title }" v-model="el.title" :disabled="form.processing">

                                        <span v-if="form.errors.title" class="text-red-400 italic">{{ form.errors.title }}</span>
                                    </div>
                                </div>

                                    <div class="flex-1 flex flex-col space-y-1">
                                        <span class="text-black font-medium">Source</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.source }" v-model="el.source" :disabled="form.processing">

                                        <span v-if="form.errors.source" class="text-red-400 italic">{{ form.errors.source }}</span>
                                    </div>
                            </template>

                            <template v-if="el.tipe == 'Pull Quote'">
                                <div class="flex">
                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Quote</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.quote }" v-model="el.quote" :disabled="form.processing">

                                        <span v-if="form.errors.quote" class="text-red-400 italic">{{ form.errors.quote }}</span>
                                    </div>

                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Author</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.author }" v-model="el.author" :disabled="form.processing">

                                        <span v-if="form.errors.author" class="text-red-400 italic">{{ form.errors.author }}</span>
                                    </div>
                                </div>
                            </template>

                            <template v-if="el.tipe == 'Quote'">
                                <div class="flex">
                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Quote</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.quote }" v-model="el.quote" :disabled="form.processing">

                                        <span v-if="form.errors.quote" class="text-red-400 italic">{{ form.errors.quote }}</span>
                                    </div>

                                    <div class="flex-1 flex flex-col space-y-1 mr-5">
                                        <span class="text-black font-medium">Author</span>

                                        <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.author }" v-model="el.author" :disabled="form.processing">

                                        <span v-if="form.errors.author" class="text-red-400 italic">{{ form.errors.author }}</span>
                                    </div>
                                </div>
                            </template>

                            <template v-if="el.tipe == 'Reference'">
                                <div v-for="(val, key) in el.detail" class="py-3">
                                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-3 rounded-md text-center shadow my-2">
                                        <div class="flex-1 flex flex-col space-y-1">
                                            <span class="text-black font-medium text-md">Item {{key+1}}</span>
                                        </div>
                                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteDetail(idx,key)" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Title</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.title }" v-model="val.title" :disabled="form.processing">
                                            <span v-if="form.errors.title" class="text-red-400 italic">{{ form.errors.title }}</span>
                                        </div>

                                        <div class="flex-1 flex flex-col mr-5">
                                            <span class="text-black font-medium py-3">Content</span>
                                                <text-editor v-model="val.content"/>
                                            <span v-if="form.errors.content" class="text-red-400 italic">{{ form.errors.content }}</span>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="pt-[1rem] pb-[1rem]">
                                    <a style="cursor:pointer" class="py-3 px-6 mt-4 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing" @click="addDetail(idx)">
                                        + Add Item
                                    </a>
                                </div>

                            </template>

                            <template v-if="el.tipe == 'FAQ'">
                                <div v-for="(val, key) in el.detail" class="py-3">
                                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-3 rounded-md text-center  shadow my-2">
                                        <div class="flex-1 flex flex-col space-y-1">
                                            <span class="text-black font-medium text-md">Item {{key+1}}</span>
                                        </div>
                                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteDetail(idx,key)" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Question</span>
                                            <input type="text" :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.question }" v-model="val.question" :disabled="form.processing">
                                            <span v-if="form.errors.question" class="text-red-400 italic">{{ form.errors.question }}</span>
                                        </div>

                                        <div class="flex-1 flex flex-col space-y-1 mr-5">
                                            <span class="text-black font-medium">Answer</span>
                                            <textarea :class="{ 'text-sm p-[4px] rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.answer }" v-model="val.answer" :disabled="form.processing" />
                                            <span v-if="form.errors.answer" class="text-red-400 italic">{{ form.errors.answer }}</span>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="pt-[1rem] pb-[1rem]">
                                    <a style="cursor:pointer" class="py-3 px-6 mt-4 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing" @click="addDetailFAQ(idx)">
                                        + Add Detail
                                    </a>
                                </div>

                            </template>

                            <template v-if="el.tipe == 'History'">
                                <div class="flex">
                                </div>
                            </template>
                        </div>
                    </details>
                </div>
            </draggable>
            
            <a style="cursor:pointer" class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing"  @click.prevent="tableprompt = true">
                + Add Section
            </a>

            <dialog-modal :max-width="'lg'" :show="tableprompt" @close="tableprompt = false">
                <div class="flex flex-col space-y-6 p-10 items-center">
                    <div class="flex flex-row gap-2 h-52">
                        <div class="flex-1 flex flex-col space-y-1">
                            <span class="text-black font-medium">Section Type</span>
                            <select-search
                                clearable
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors.section_type,
                                }"
                                v-model="form.section_type"
                                :disabled="form.processing"
                                :options="withHistory ? tipeHistory : tipeOptions"
                            >
                            </select-search>
                        </div>
                    </div>
                    <div class="w-full pt-5">
                        <div class="flex flex-row justify-center space-x-4">
                            <button
                                type="button"
                                class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                                @click.prevent="tableprompt = false"
                            >
                                Cancel
                            </button>
                            <button
                                type="button"
                                class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
                                @click.prevent="createSection(form.section_type)"
                            >
                                Create Section
                            </button>
                        </div>
                    </div>
                </div>
            </dialog-modal>
            
            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="backUri"
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
import DialogModal from "@/Components/Modal/DialogModal.vue";
import SelectSearch from "@/Components/Select/SelectSearch.vue";
import PreviewImage from "@/Components/Image/Preview.vue";
import { VueDraggableNext } from 'vue-draggable-next'

export default {
    name: "FlexyPage",
    components: {
        Link,
        TextEditor,
        DialogModal,
        SelectSearch,
        PreviewImage,
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
        isLaw: {
            type: Boolean,
            default: () => false,
        },
        withHistory: {
            type: Boolean,
            default: () => false,
        },
        withTitle: {
            type: Boolean,
            default: () => false,
        },
        withCountry: {
            type: Boolean,
            default: () => false,
        },
        actionUri: {
            type: String,
            default: () => "",
        },
        backUri: {
            type: String,
            default: () => "",
        },
        data: {
            type: Object,
            default: () => null,
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
        countryOptions: {
            type: Array,
            default: () => [],
        }
    },
    setup(props) {
        const tableprompt = ref(false);
        const promptopen = ref(true);

        const form = useForm({
            id: "",
            title: "",
            section_type:"",
            country_id:"",
            section: [],
        });

        const tipeOptions = ref([
            {
                label: "Paragraph",
                value: "Paragraph",
            },
            {
                label: "Table",
                value: "Table",
            },
            {
                label: "Image",
                value: "Image",
            },
            {
                label: "Video",
                value: "Video",
            },
            {
                label: "Pull Quote",
                value: "Pull Quote",
            },
            {
                label: "Quote",
                value: "Quote",
            },
            {
                label: "Reference",
                value: "Reference",
            },
            {
                label: "FAQ",
                value: "FAQ",
            },

        ]);

        const tipeHistory = ref([
            {
                label: "Paragraph",
                value: "Paragraph",
            },
            {
                label: "Table",
                value: "Table",
            },
            {
                label: "Image",
                value: "Image",
            },
            {
                label: "Video",
                value: "Video",
            },
            {
                label: "Pull Quote",
                value: "Pull Quote",
            },
            {
                label: "Quote",
                value: "Quote",
            },
            {
                label: "Reference",
                value: "Reference",
            },
            {
                label: "FAQ",
                value: "FAQ",
            },
            {
                label: "History",
                value: "History",
            },

        ]);


        const sizeOptions = ref([
            {
                label: "H1",
                value: "h1",
            },
            {
                label: "H2",
                value: "h2",
            },
            {
                label: "H3",
                value: "h3",
            },
            {
                label: "H4",
                value: "h4",
            },
            {
                label: "H5",
                value: "h5",
            },
            {
                label: "H6",
                value: "h6",
            },

        ]);

        onMounted(() => {
            if (props.data) {
                form.id = props.data.id;
                form.title = props.data.title;
                form.country_id = props.data.country_id;

                if(props.paragraph) {
                    _.forEach(props.paragraph, (value) => {
                        var detail = [];

                        if(value.detail) {
                            _.forEach(value.detail, (details) => {
                                detail.push({
                                    id:details.id,
                                    title:details.title,
                                    description:details.description,
                                    image_path:details.icon,
                                    button_label:details.button_label,
                                    button_url:details.button_url
                                });
                            });
                        }

                        form.section.push({
                            id: value.id,
                            tipe:'Paragraph',
                            title:value.title,
                            content:value.content,
                            position:value.position,
                            title_size: value.title_size,
                            detail:detail,
                        })

                      

                    });
                }

                if(props.table) {
                    _.forEach(props.table, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:'Table',
                            content:value.content,
                            position:value.position,
                        })
                    });
                }

                if(props.media) {
                    _.forEach(props.media, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:value.tipe,
                            title:value.title,
                            image_path:value.image,
                            source:value.source,
                            position:value.position,
                            video:value.video,
                        })
                    });
                }

                if(props.quote) {
                    _.forEach(props.quote, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:value.tipe,
                            quote:value.quote,
                            author:value.author,
                            position:value.position,
                        })
                    });
                }

                if(props.reference) {
                    _.forEach(props.reference, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:'Reference',
                            detail:value.detail,
                            position:value.position,
                        })
                    });
                }

                if(props.faq) {
                    _.forEach(props.faq, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:'FAQ',
                            detail:value.detail,
                            position:value.position,
                        })
                    });
                }
                
                if(props.history) {
                    _.forEach(props.history, (value) => {
                        form.section.push({
                            id: value.id,
                            tipe:'History',
                            position:value.position,
                        })
                    });
                }

                form.section = _.sortBy(form.section, 'position');
            }
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                _method: props.httpMethod,
            })).post(props.actionUri);
        }

        function createSection(type) {
            const number = form.section.length;
            if(type == 'Paragraph') {
                form.section.push({
                    tipe:'Paragraph',
                    title:'',
                    title_size:'',
                    content:'',
                    detail:[],
                    number:number+1
                })
            } else if(type == 'Table') {
                form.section.push({
                    tipe:'Table',
                    content:'',
                    number:number+1
                })
            } else if(type == 'Image') {
                form.section.push({
                    tipe:'Image',
                    title:'',
                    images:'',
                    source:'',
                    image_path:'',
                    number:number+1
                })
            } else if(type == 'Video') {
                form.section.push({
                    tipe:'Video',
                    title:'',
                    video:'',
                    source:'',
                    number:number+1
                })
            } else if(type == 'Pull Quote') {
                form.section.push({
                    tipe:'Pull Quote',
                    quote:'',
                    author:'',
                    number:number+1
                })
            } else if(type == 'Quote') {
                form.section.push({
                    tipe:'Quote',
                    quote:'',
                    author:'',
                    number:number+1
                })
            } else if(type == 'Reference') {
                form.section.push({
                    tipe:'Reference',
                    detail: [],
                    number:number+1
                })
                this.addDetail(form.section.length-1);
            } else if(type == 'FAQ') {
                form.section.push({
                    tipe:'FAQ',
                    detail: [],
                    number:number+1
                })
                this.addDetailFAQ(form.section.length-1);
            } else if(type == 'History') {
                form.section.push({
                    tipe:'History',
                    number:number+1
                })
            }
            
            tableprompt.value = false;
            form.section_type = '';
        }

        function deleteSetion(idx) {
            if (confirm('Are you sure you want to delete this section?')) {
                form.section = _.filter(form.section, (el, key) => {
                    return key != idx
                })
            }
        }

        function onFileChangeDetail(evt,idx) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.section[idx].image_path = URL.createObjectURL(files[0]);
            form.section[idx].images = files[0];
        }

        function onFileChangeDetailParagraph(evt,idx,key) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.section[idx].detail[key].image_path = URL.createObjectURL(files[0]);
            form.section[idx].detail[key].icons = files[0];
        }

        function addDetail(idx) {
            form.section[idx].detail.push({
                content:'',
            })
        }

        function addDetailFAQ(idx) {
            form.section[idx].detail.push({
                question:'',
                answer:'',
            })
        }

        function addDetailParagraph(idx) {
            form.section[idx].detail.push({
                title:'',
                description:'',
                icons: '',
                image_path:'',
                button_label:'',
                button_url:''
            })
        }
        
        function deleteDetail(idx,key) {
            if (confirm('Are you sure you want to delete this data?')) {
                form.section[idx].detail = _.filter(form.section[idx].detail, (el, keys) => {
                    return keys != key
                })
            }
        }

        return {
            deleteSetion,
            createSection,
            form,
            submit,
            tableprompt,
            tipeOptions,
            onFileChangeDetail,
            addDetail,
            deleteDetail,
            addDetailParagraph,
            onFileChangeDetailParagraph,
            addDetailFAQ,
            sizeOptions,
            promptopen,
            tipeHistory
        };
    },
};
</script>
