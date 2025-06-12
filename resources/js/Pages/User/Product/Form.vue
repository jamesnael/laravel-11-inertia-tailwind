<template>
    <form @submit.prevent="submit()">
        <div class="flex flex-col space-y-4 mb-2" v-if="product">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Company Name <span class="text-red-400">*</span>
                        </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        }"
                        :value="product.product_company.title"
                        :disabled="true"
                    />
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Company Contact Email <span class="text-red-400">*</span>
                        </span>
                        <input
                            type="text"
                            :class="{
                                'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            }"
                            :value="product.product_company.contact_email"
                            :disabled="true"
                        />
                </div>
            </div>
        </div>

        <hr class="my-8" v-if="product">

        <div class="flex flex-col space-y-4">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
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
                    <span class="text-black font-medium">
                        Category <span class="text-red-400">*</span>
                    </span>
                        <multiselect
                            v-model="form.category_id"
                            :options="categories"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Select Category"
                            label="label"
                            track-by="value"
                        >
                            <template
                                slot="selection"
                                slot-scope="{ values, search, isOpen }"
                            >
                                <span
                                    class="multiselect__single"
                                    v-if="values.length"
                                    v-show="!isOpen"
                                >
                                    {{ values.length }} options selected</span
                                >
                            </template>
                        </multiselect>
                    <span
                        v-if="form.errors.category_id"
                        class="text-red-400 italic"
                        >{{ form.errors.category_id }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Distribution Countries <span class="text-red-400">*</span>
                    </span>
                        <multiselect
                            v-model="form.country_id"
                            :options="countryOptions"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Select Country"
                            label="label"
                            track-by="value"
                        >
                            <template
                                slot="selection"
                                slot-scope="{ values, search, isOpen }"
                            >
                                <span
                                    class="multiselect__single"
                                    v-if="values.length"
                                    v-show="!isOpen"
                                >
                                    {{ values.length }} options selected</span
                                >
                            </template>
                        </multiselect>
                    <span
                        v-if="form.errors.country_id"
                        class="text-red-400 italic"
                        >{{ form.errors.country_id }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Facebook Link 
                        </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.facebook_link,
                        }"
                        v-model="form.facebook_link"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.facebook_link"
                        class="text-red-400 italic"
                        >{{ form.errors.facebook_link }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Twitter Link 
                        </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.twitter_link,
                        }"
                        v-model="form.twitter_link"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.twitter_link"
                        class="text-red-400 italic"
                        >{{ form.errors.twitter_link }}</span
                    >
                </div>

                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Instagram Link
                        </span>
                    <input
                        type="text"
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.instagram_link,
                        }"
                        v-model="form.instagram_link"
                        :disabled="form.processing"
                    />
                    <span
                        v-if="form.errors.instagram_link"
                        class="text-red-400 italic"
                        >{{ form.errors.instagram_link }}</span
                    >
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div v-if="product" class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Creator
                    </span>
                    <input
                        type="text"
                        class="rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100"
                        :value="product.product_creator.nama_lengkap"
                        readonly
                    />
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Thumbnail Image
                        <span v-if="!product" class="text-red-400"
                            >*</span
                        ></span
                    >
                    <input
                        type="file"
                        accept="image/*"
                        :class="{
                            'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.thumbnail_image,
                        }"
                        @change="onThumbnailChange($event)"
                        :disabled="form.processing"
                    />
                    <preview-image :src="thumbnail_image_path" />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <span
                        v-if="form.errors.thumbnail_image"
                        class="text-red-400 italic"
                        >{{ form.errors.thumbnail_image }}</span
                    >
                </div>
                
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">Company <span class="text-red-400">*</span></span>
                    <select-search
                        clearable
                        :class="{ 'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.company_id }"
                        v-model="form.company_id"
                        :disabled="form.processing"
                        :options="companyOptions">
                    </select-search>
                    <span v-if="form.errors.company_id" class="text-red-400 italic">{{ form.errors.company_id }}</span>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="h-auto flex flex-col">
                    <span class="text-black font-medium">
                        Description
                        <span class="text-red-400">*</span>
                    </span>
                    <text-editor v-model="form.description" :h3only="true"/>

                    <span
                        v-if="form.errors.description"
                        class="text-red-400 italic"
                        >{{ form.errors.description }}</span
                    >
                </div>
            </div>

            <hr>

            <div class="text-center">
                <h2 class="text-dark-7 text-lg font-medium mr-auto">
                    Related Files
                </h2>
            </div>

            <div v-for="(el, idx) in form.related_files" class="py-3">
                <span class="text-black font-medium">Related Files {{idx+1}}</span>
                <div class="flex">

                    <div class="flex-1 flex flex-col space-y-2 mr-5">
                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                File
                            </span>
                            <input
                                type="file"
                                accept="application/pdf"
                                :class="{
                                    'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors.file,
                                }"
                                @change="onFileChangeRelatedFiles($event,idx)"
                                :disabled="form.processing"
                            />
                            <!-- <a v-if="el.file_path" style="color: revert !important;text-decoration: revert !important;" :href="el.file_path" target="_blank">{{el.file_name}} (Click here to preview current file)</a> -->
                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                            >
                                {{ form.progress.percentage }}%
                            </progress>
                            <span v-if="el.file == ''" class="text-red-400 italic">The File Field is Required</span>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col space-y-2 mr-5">
                        <span class="text-black font-medium">Name <span class="text-red-400">*</span></span>
                        <input type="text" :class="{ 'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true, 'border-red-400': form.errors.file_name }" v-model="el.file_name" :disabled="form.processing">
                        <span v-if="form.errors.file_name" class="text-red-400 italic">{{ form.errors.file_name }}</span>
                        <span v-if="el.file_name == ''" class="text-red-400 italic">The File Name Field is Required</span>
                    </div>

                    <div class="flex-initial w-1/12">
                        <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent mt-10" @click.prevent="deleteRelatedFiles(idx)" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 stroke-current text-red-600" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        </button>
                    </div>
                </div>
                <div class="pt-3">
                    <a v-if="el.file_path" style="color: revert !important;text-decoration: revert !important;" :href="el.file_path" target="_blank">(Click here to preview current file)</a>
                </div>
            </div>

            <a style="cursor:pointer" class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing" @click="tambahRelatedFiles()">
                + Add Related Files
            </a>

            <div class="text-center">
                <h2 class="text-dark-7 text-lg font-medium mr-auto">
                    Media
                </h2>
            </div>

            <div v-for="(el, idx) in form.media">
                <div v-if="el.tipe == 'Photo'">
                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-2 rounded-md text-center  shadow my-2">
                        <div class="flex-1 flex flex-col space-y-1">
                            <span class="text-black font-medium text-md">Photo {{idx+1}}</span>
                        </div>
                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteMedia(idx)" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex md:space-x-8">
                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Photo File
                            </span>
                            <input
                                type="file"
                                accept="image/png,image/jpeg,image/jpg"
                                :class="{
                                    'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.image'],
                                }"
                                :disabled="form.processing"
                                @change="onPhotoChange($event, idx)"
                            />
                            <small class="text-red-400">Minimum Size 1024 x 536</small>
                            <preview-image :src="el.image_path" />
                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                            >
                                {{ form.progress.percentage }}%
                            </progress>
                            <span
                                v-if="form.errors['media.' + idx + '.image']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.image'] }}</span
                            >
                        </div>

                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Copyright
                            </span>
                            <input
                                type="text"
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.copyright'],
                                }"
                                v-model="el.copyright"
                                :disabled="form.processing"
                            />
                            <span
                                v-if="form.errors['media.' + idx + '.copyright']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.copyright'] }}</span
                            >
                        </div>
                    </div>
                </div>

                <div v-if="el.tipe == 'Video Upload'">
                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-2 rounded-md text-center  shadow my-2">
                        <div class="flex-1 flex flex-col space-y-1">
                            <span class="text-black font-medium text-md">Video {{idx+1}}</span>
                        </div>
                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteMedia(idx)" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex md:space-x-8">
                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Video File
                            </span>
                            <input
                                type="file"
                                accept="video/*"
                                :class="{
                                    'rounded-md border border-black px-4 py-2 focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.video'],
                                }"
                                :disabled="form.processing"
                                @change="onVideoChange($event, idx)"
                            />
                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                            >
                                {{ form.progress.percentage }}%
                            </progress>
                            <span
                                v-if="form.errors['media.' + idx + '.video']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.video'] }}</span
                            >
                        </div>

                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Copyright
                            </span>
                            <input
                                type="text"
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.copyright'],
                                }"
                                v-model="el.copyright"
                                :disabled="form.processing"
                            />
                            <span
                                v-if="form.errors['media.' + idx + '.copyright']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.copyright'] }}</span
                            >
                        </div>
                    </div>
                    <div class="pt-3">
                        <a v-if="el.video_path" style="color: revert !important;text-decoration: revert !important;" :href="el.video_path" target="_blank">(Click here to preview current video)</a>
                    </div>
                </div>

                <div v-if="el.tipe == 'Video Link'">
                    <div class="flex font-semibold bg-gray-200 focus:bg-gray-200 m-1 p-2 rounded-md text-center  shadow my-2">
                        <div class="flex-1 flex flex-col space-y-1">
                            <span class="text-black font-medium text-md">Video Link {{idx+1}}</span>
                        </div>
                        <div class="flex-1 flex flex-col space-y-1 flex-initial w-100 my-auto py-auto">
                            <button type="button" class="appearance-none outline-none ml-3 focus:border-transparent focus:outline-none bg-transparent" @click.prevent="deleteMedia(idx)" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex md:space-x-8">
                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Video Link (Youtube) <span class="text-red-400">*</span>
                                </span>
                            <input
                                type="text"
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.video_link'],
                                }"
                                v-model="el.video_link"
                                :disabled="form.processing"
                            />
                            <span
                                v-if="form.errors['media.' + idx + '.video_link']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.video_link'] }}</span
                            >
                        </div>

                        <div class="flex-1 flex flex-col space-y-2">
                            <span class="text-black font-medium">
                                Copyright
                            </span>
                            <input
                                type="text"
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors['media.' + idx + '.copyright'],
                                }"
                                v-model="el.copyright"
                                :disabled="form.processing"
                            />
                            <span
                                v-if="form.errors['media.' + idx + '.copyright']"
                                class="text-red-400 italic"
                                >{{ form.errors['media.' + idx + '.copyright'] }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <a style="cursor:pointer" class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed" :disabled="form.processing"  @click.prevent="tableprompt = true">
                + Add Media
            </a>

            <dialog-modal :max-width="'lg'" :show="tableprompt" @close="tableprompt = false">
                <div class="flex flex-col space-y-6 p-10 items-center">
                    <div class="flex flex-row gap-2 h-52">
                        <div class="flex-1 flex flex-col space-y-1">
                            <span class="text-black font-medium">Media Type</span>
                            <select-search
                                clearable
                                :class="{
                                    'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                                    'border-red-400': form.errors.media_type,
                                }"
                                v-model="form.media_type"
                                :disabled="form.processing"
                                :options="mediaOptions"
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
                                @click.prevent="createMedia(form.media_type)"
                            >
                                Create Media
                            </button>
                        </div>
                    </div>
                </div>
            </dialog-modal>

            <div class="flex-1 flex flex-col space-y-2" v-if="product && product.approval_status == 'Approved'">
                    <span class="text-black font-medium">
                        Status
                        <span class="text-red-400">*</span>
                    </span>
                    <select-search
                        disable-search
                        :class="{
                            'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                            'border-red-400': form.errors.status,
                        }"
                        v-model="form.status"
                        :disabled="product && product.approval_status != 'Approved'"
                        :options="statusOptions"
                    >
                    </select-search>
                    <span v-if="form.errors.status" class="text-red-400 italic">
                        {{ form.errors.status }}
                    </span>
                </div>

            <div class="flex flex-row justify-end space-x-4">
                <Link
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                    :href="route('user.product.index')"
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
                <div
                    v-if="!product || product.approval_status == 'Draft'"
                    style="cursor: pointer;"
                    class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
                    @click="submit('draft')"
                    :disabled="form.processing"
                >
                    Save as Draft
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { ref, onMounted } from "vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import PreviewImage from "@/Components/Image/Preview.vue";
import SelectSearch from "@/Components/Select/SelectSearch.vue";
import DialogModal from "@/Components/Modal/DialogModal.vue";
import FlexyPageForm from "@/Components/FlexyPage/FlexyPageForm.vue";
import TextEditor from "@/Components/Input/TextEditor.vue";


export default {
    name: "MasterAdminProductForm",
    components: {
        Link,
        PreviewImage,
        SelectSearch,
        DialogModal,
        FlexyPageForm,
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
        product: {
            type: Object,
            default: () => null,
        },
        categories: {
            type: Array
        },
        subCategories: {
            type: Object,
            default: () => null,
        },
        countryOptions: {
            type: Object,
            default: () => null,
        },

        companyOptions: {
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
        data_related_files: {
            type: Object,
            default: () => null,
        }
    },
    setup(props) {
        const form = useForm({
            title: "",
            category_id: "",
            country_id: "",
            is_responsible: "",
            is_agree: "",
            media: [],
            approval_status: "",
            admin_comment: "",
            related_files: [],
            company_id: "",
            section: [],
            twitter_link: "",
            facebook_link: "",
            instagram_link: "",
            thumbnail_image: "",
            description: "",
            status: "",
            is_draft: false,
        });

        onMounted(() => {
            if (props.product) {
                form.title = props.product.title;
                form.company_id = props.product.company_id;
                form.facebook_link = props.product.facebook_link;
                form.twitter_link = props.product.twitter_link;
                form.instagram_link = props.product.instagram_link;
                form.country_id = props.product.product_country;
                form.category_id = props.product.product_category;
                form.description = props.product.description;
                form.approval_status = props.product.approval_status ?? '';
                form.status = props.product.status;

                thumbnail_image_path.value = props.product.thumbnail_image;

                props.product.product_photo.forEach(item => {
                    if(item.image != null) {
                        form.media.push({
                            tipe:'Photo',
                            id: item.id,
                            image: '',
                            image_path: ref(item.image),
                            copyright:item.copyright,
                        });
                    } else if(item.video != null) {
                        form.media.push({
                            tipe:'Video Upload',
                            id: item.id,
                            video: '',
                            video_path: ref(item.video),
                            copyright:item.copyright,
                        });
                    } else if(item.video_link != null) {
                        form.media.push({
                            tipe:'Video Link',
                            id: item.id,
                            video_link: item.video_link,
                            copyright:item.copyright,
                        });
                    }
                });

                if(props.data_related_files) {
                    _.forEach(props.data_related_files, (value) => {
                        form.related_files.push({
                            id:value.id,
                            file_name:value.file_name,
                            file_path:value.file,
                        })
                    });
                }

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
                        });
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

                if (props.media) {
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

        const thumbnail_image_path = ref("");
        const additional_info_path = ref("");
        const tableprompt = ref(false);

        function submit(draft) {
            if(!draft) {
                if (!form.media.length) {
                    // media is not added
                    return alert('Please add at least 1 media file!');
                }

                if (form.media.length) {
                    // check if file is uploaded or not when creating a media
                    let isAnyEmptyFile = false;
                    form.media.forEach(item => {
                        if (item.tipe == 'Photo' && item.image == '' && !item.hasOwnProperty('id')) {
                            isAnyEmptyFile = true
                        }

                        if (item.tipe == 'Video Upload' && item.video == '' && !item.hasOwnProperty('id')) {
                            isAnyEmptyFile = true
                        }

                        if (item.tipe == 'Video Link' && item.video_link == '' && !item.hasOwnProperty('id')) {
                            isAnyEmptyFile = true
                        }
                    });

                    if (isAnyEmptyFile) {
                        return alert('Please upload the media file!');
                    }
                }

                // if (!form.section.length) {
                //     // content is not added
                //     return alert('Please add at least 1 content!');
                // }

                form.transform((data) => ({
                    ...data,
                    _method: props.httpMethod,
                })).post(props.actionUri);
            } else {
                form.is_draft = true;
                if(!props.product) {
                    form.transform((data) => ({
                        ...data,
                        _method: props.httpMethod,
                    })).post(route('user.product.draft'));
                } else {
                    form.transform((data) => ({
                        ...data,
                        _method: props.httpMethod,
                    })).post(props.actionUri);
                }

            }

        }

        function checkIsResponsible(evt) {
            const checked = evt.target.checked;
            form.is_responsible = checked;
        }

        function checkIsAgree(evt) {
            const checked = evt.target.checked;
            form.is_agree = checked;
        }

        function addPhoto() {
            form.photo.push({
                id: '',
                image: '',
                image_path: ref(""),
            });
        }

        function deleteMedia(index) {
            form.media.splice(index, 1);
        }

        function onPhotoChange(evt, index) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.media[index].image = files[0];
            form.media[index].image_path = URL.createObjectURL(files[0]);
        }

        function onVideoChange(evt, index) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.media[index].video = files[0];
        }

        const approvalOptions = ref([
            {
                label: "Approve",
                value: "Approved",
            },
            {
                label: "Waiting Approval",
                value: "Waiting Approval",
            },
            {
                label: "Draft",
                value: "Draft",
            },
        ]);

        const statusOptions = ref([
            {
                label: "Published",
                value: "Published",
            },
            {
                label: "Unpublished",
                value: "Unpublished",
            },
        ]);

        const mediaOptions = ref([
            {
                label: "Photo",
                value: "Photo",
            },
            {
                label: "Video Link (Youtube)",
                value: "Video Link",
            },
        ]);

        function onFileChangeRelatedFiles(evt,idx) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.related_files[idx].file = files[0];
        }

        function tambahRelatedFiles() {
            form.related_files.push({
                file:'',
                file_name:''
            })
        }

        function deleteRelatedFiles(idx) {
            form.related_files = _.filter(form.related_files, (el, key) => {
                return key != idx
            })
        }

        function createMedia(value) {
            tableprompt.value = false;

            if(value == 'Photo') {
                //validasi photo max 7
                let temp_array = [];
                temp_array = _.filter(form.media, (el, key) => {
                    return el.tipe == 'Photo'
                })

                if(temp_array.length >= 7) {
                    form.media_type = '';
                    return alert('Maximum Upload Photo!')
                } 

                form.media.push({
                    tipe:'Photo',
                    image: '',
                    image_path: ref(""),
                    copyright: '',
                });
            } else if(value == 'Video Upload') {
                form.media.push({
                    tipe:'Video Upload',
                    video: '',
                    copyright: '',
                });
            } else if(value == 'Video Link') {
                //validasi video link 1
                let temp_array_video = [];
                temp_array_video = _.filter(form.media, (el, key) => {
                    return el.tipe == 'Video Link'
                })

                if(temp_array_video.length >= 1) {
                    form.media_type = '';
                    return alert('Maximum Upload Video Link!')
                } 

                form.media.push({
                    tipe:'Video Link',
                    video_link: '',
                    copyright: '',
                });
            }
            


            form.media_type = '';
        }

        function onThumbnailChange(evt) {
            let files = evt.target.files || evt.dataTransfer.files;
            if (!files.length) return;
            form.thumbnail_image = files[0];
            thumbnail_image_path.value = URL.createObjectURL(files[0]);
        }

        return {
            form,
            submit,
            thumbnail_image_path,
            additional_info_path,
            checkIsAgree,
            checkIsResponsible,
            addPhoto,
            deleteMedia,
            onPhotoChange,
            approvalOptions,
            onFileChangeRelatedFiles,
            tambahRelatedFiles,
            deleteRelatedFiles,
            tableprompt,
            mediaOptions,
            createMedia,
            onVideoChange,
            onThumbnailChange,
            statusOptions
        };
    },
};
</script>
