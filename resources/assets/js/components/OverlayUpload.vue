<template>
    <div class="top-header-overlay">
        <img :src="overlay ? getImageLink(overlay) : '/img/top-header2.jpg'">
        <vue-core-image-upload
            v-if="uploadUrl"
            class="fileupload"
            :crop="false"
            :headers="headers"
            @imageuploaded="imageuploaded"
            extensions="png,gif,jpeg,jpg"
            :url="uploadUrl"
        >
            <btn class="btn bg-violet btn-xs mt-0 mb-0">Change overlay</btn>
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
            overlay: ''
        }),

        components: {
            'vue-core-image-upload': VueCoreImageUpload
        },

        created () {
            this.overlay = this.uimg;
            this.uploadUrl = this.uploadapi;
        },

        methods: {
            imageuploaded(response) {
                if(response.data!=undefined)
                    this.overlay = response.data[this.dataname];
            },
        }
    }
</script>
