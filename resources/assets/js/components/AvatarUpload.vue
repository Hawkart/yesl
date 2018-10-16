<template>
    <div class="author-thumb">
        <img :src="getImageLink(avatar)" :alt="user.name">
        <vue-core-image-upload
                crop-ratio="1:1"
                class="fileupload"
                :crop="true"
                :headers="headers"
                @imageuploaded="imageuploaded"
                extensions="png,gif,jpeg,jpg"
                :url="uploadUrl">
            <span>Upload</span>
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
            uploadUrl: '/users/avatar',
            avatar: ''
        }),

        components: {
            'vue-core-image-upload': VueCoreImageUpload
        },

        created () {
            this.avatar = this.user.avatar
        },

        methods: {
            imageuploaded(response) {
                this.avatar = response.data.avatar;
            },
        }
    }
</script>