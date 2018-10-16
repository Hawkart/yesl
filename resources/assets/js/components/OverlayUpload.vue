<template>
    <div class="top-header-overlay">
        <img :src="overlay ? getImageLink(overlay) : '/img/top-header2.jpg'" :alt="user.name">
        <vue-core-image-upload
                class="fileupload"
                :crop="false"
                :headers="headers"
                @imageuploaded="imageuploaded"
                extensions="png,gif,jpeg,jpg"
                :url="uploadUrl">
            <span>Change overlay</span>
        </vue-core-image-upload>
    </div>
</template>

<script>
    import VueCoreImageUpload from 'vue-core-image-upload'

    export default {
        props: ['user'],
        data: () => ({
            headers: {
                'X-Csrf-Token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            uploadUrl: '/users/overlay',
            overlay: ''
        }),

        components: {
            'vue-core-image-upload': VueCoreImageUpload
        },

        created () {
            this.overlay = this.user.overlay;
        },

        methods: {
            imageuploaded(response) {
                if(response.data!=undefined)
                    this.overlay = response.data.overlay;
            },
        }
    }
</script>