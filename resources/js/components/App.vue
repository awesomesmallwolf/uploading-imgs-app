<template>
    <div class="mx-20">
        <file-pond
            name="image"
            ref="pond"
            class-name="my-pond"
            label-idle="Drop files here..."
            allow-multiple="true"
            accepted-file-types="image/jpeg, image/png"
            @init="handleFilePondInit"
            @processfile="handleUploadProccess"
        />
        <div>
            <div class="text-3xl text-blue-400 font-semibold text-center p-5">
                Images Gallary
            </div>

            <div class="grid grid-cols-4 gap-3">
                <div v-for="(image, key) in images" :key="key">
                    <img
                        :src="'/storage/images/' + image"
                        class="w-full h-48"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Import FilePond
import vueFilePond, { setOptions } from "vue-filepond";

// Import plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

setOptions({
    server: {
        process: {
            url: "./upload",
            headers: {
                "X-CSRF-TOKEN": document.head.querySelector(
                    "meta[name='csrf_token']"
                ).content,
            },
        },
    },
});
// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default {
    name: "app",
    components: {
        FilePond,
    },
    data() {
        return { images: [] };
    },
    mounted() {
        axios
            .get("/images")
            .then(({ data }) => (this.images = data))
            .catch((err) => console.log(err));
    },
    methods: {
        handleFilePondInit: function () {
            console.log("FilePond has initialized");

            // example of instance method call on pond reference
            this.$refs.pond.getFiles();
        },
        handleUploadProccess(error, file) {
            if (error) {
                console.log(error);
                return;
            }

            this.images = [JSON.parse(file.serverId).name, ...this.images];
        },
    },
};
</script>
