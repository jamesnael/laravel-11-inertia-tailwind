<template>
    <div class="mb-4 map-form">
        <div
            class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-8"
        >
            <div
                :id="elementId"
                class="view-map w-full h-[400px] relative rounded-md shadow-md border my-4"
            ></div>
        </div>
        <h4 v-if="isShowFields">
            Klik lokasi pada map untuk mendapatkan latitude dan longitude
        </h4>

        <div
            class="flex flex-col mb-4 space-y-4 md:flex-row md:space-y-0 md:space-x-8"
        >
            <div class="flex flex-col flex-1 space-y-2" v-if="isShowFields">
                <span class="font-medium text-black">
                    Latitude <span class="text-red-400">*</span>
                </span>
                <input
                    type="text"
                    v-model="latitude"
                    :name="latitudeInputName"
                    :disabled="disabled"
                    :readonly="readonly"
                    @input="$emit('update:latitudeValue', latitude)"
                    :class="{
                        'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        'border-red-400': latitudeError,
                    }"
                />
                <span v-if="latitudeError" class="italic text-red-400">{{
                    latitudeError
                }}</span>
            </div>

            <!-- Longitude -->
            <div class="flex flex-col flex-1 space-y-2" v-if="isShowFields">
                <span class="font-medium text-black">
                    Longitude <span class="text-red-400">*</span>
                </span>
                <input
                    type="text"
                    v-model="longitude"
                    :name="longitudeInputName"
                    :disabled="disabled"
                    :readonly="readonly"
                    @input="$emit('update:longitudeValue', longitude)"
                    :class="{
                        'rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:bg-gray-100': true,
                        'border-red-400': longitudeError,
                    }"
                />
                <span v-if="longitudeError" class="italic text-red-400">{{
                    longitudeError
                }}</span>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import { Loader } from "@googlemaps/js-api-loader";

export default {
    name: "Maps",
    props: {
        latitudeValue: {
            type: String,
            default: "",
        },
        longitudeValue: {
            type: String,
            default: "",
        },
        latitudeInputName: {
            type: String,
            default: "",
        },
        longitudeInputName: {
            type: String,
            default: "",
        },
        longitudeError: {
            type: String,
            default: "",
        },
        latitudeError: {
            type: String,
            default: "",
        },
        disabled: {
            type: Boolean,
            default: function () {
                return false;
            },
        },
        readonly: {
            type: Boolean,
            default: function () {
                return false;
            },
        },
        isRequired: {
            type: Boolean,
            default: function () {
                return false;
            },
        },
        isSearch: {
            type: Boolean,
            default: function () {
                return true;
            },
        },
        isShowFields: {
            type: Boolean,
            default: function () {
                return true;
            },
        },
        elementId: {
            type: String,
            default: "view-map",
        },
        apiKey: {
            type: String,
            default: "",
        },
    },
    emits: ["update:latitudeValue", "update:longitudeValue"],
    data() {
        return {
            latitude: this.latitudeValue || "",
            longitude: this.longitudeValue || "",
        };
    },
    async mounted() {
        const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

        const loader = new Loader({
            apiKey: apiKey,
            version: "weekly",
            libraries: ["places"],
            language: "id",
        });

        const google = await loader.load(); 
        
        const map = new google.maps.Map(document.getElementById("view-map"), {
            center: { lat: -6.2, lng: 106.8 },
            zoom: 12,
        });

        this.checkGoogleInit(); 
    },
    watch: {
        latitude(newVal) {
            this.$emit("update:latitudeValue", newVal);
        },
        longitude(newVal) {
            this.$emit("update:longitudeValue", newVal);
        },
    },
    methods: {
        checkGoogleInit() {
            var self = this;
            setTimeout(function () {
                if (typeof google === "undefined") {
                    self.checkGoogleInit();
                } else {
                    self.GMapsInit();
                }
            }, 1000);
        },
        GMapsInit() {
            if (this.readonly || this.disabled) {
                if (this.latitudeValue) {
                    this.latitude = this.latitudeValue;
                }
                if (this.longitudeValue) {
                    this.longitude = this.longitudeValue;
                }
            } else {
                if (this.latitudeValue && this.latitude == "") {
                    this.latitude = this.latitudeValue;
                }
                if (this.longitudeValue && this.longitude == "") {
                    this.longitude = this.longitudeValue;
                }
            }

            if (this.latitude && this.longitude) {
                var map = new google.maps.Map(
                    document.getElementById(this.elementId),
                    {
                        center: {
                            lat: parseFloat(this.latitude),
                            lng: parseFloat(this.longitude),
                        },
                        zoom: 14,
                    }
                );

                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(this.latitude),
                        lng: parseFloat(this.longitude),
                    },
                    map: map,
                });
                map.panTo({
                    lat: parseFloat(this.latitude),
                    lng: parseFloat(this.longitude),
                });
            } else {
                var map = new google.maps.Map(
                    document.getElementById(this.elementId),
                    {
                        center: { lat: -6.1767287, lng: 106.829541 },
                        zoom: 14,
                    }
                );

                var marker;
            }

            if (this.isShowFields) {
                map.addListener("click", (mapsMouseEvent) => {
                    this.latitude = mapsMouseEvent.latLng.lat();
                    this.longitude = mapsMouseEvent.latLng.lng();

                    if (marker) {
                        marker.setMap(null);
                    }
                    marker = new google.maps.Marker({
                        position: mapsMouseEvent.latLng,
                        map: map,
                    });
                    map.panTo(mapsMouseEvent.latLng);

                    this.$emit("update:latitudeValue", this.latitude);
                    this.$emit("update:longitudeValue", this.longitude);
                });
            }
        },
    },
};
</script>
<style>
.view-map {
    min-height: 400px;
    height: 100%;
}
</style>
