<template>
    <div class="author-thumb">
        <img :src="getImageLink(avatar)">
        <vue-core-image-upload v-if="uploadUrl"
            crop-ratio="1:1"
            class="fileupload"
            :crop="true"
            :headers="headers"
            @imageuploaded="imageuploaded"
            extensions="png,gif,jpeg,jpg"
            :url="uploadUrl"
        >
            <btn class="btn bg-violet btn-xs mt-0 mb-0" data-toggle="tooltip" data-placement="right" data-original-title="Upload logo">Upload</btn>
        </vue-core-image-upload>
    </div>
</template>

<script>
    import VueCoreImageUpload from 'vue-core-image-upload'

    export default {
        props: ['uimg', 'uploadapi', 'dataname'],
        data: () => ({
            headers: {
                'X-Csrf-Token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            uploadUrl: '',
            avatar: ''
        }),

        components: {
            'vue-core-image-upload': VueCoreImageUpload
        },

        created () {
            this.avatar = this.uimg;
            this.uploadUrl = this.uploadapi;
        },

        methods: {
            imageuploaded(response) {
                if(response.data!=undefined)
                    this.avatar = response.data[this.dataname];
            },
        }
    }
</script>
