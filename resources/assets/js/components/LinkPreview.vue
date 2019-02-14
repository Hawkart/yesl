<template>
    <div>
        <div id="loader-container" v-if="!response && validUrl">
            <slot name="loading">
                <div class="spinner"></div>
            </slot>
        </div>
        <div v-if="response">
            <slot :img="response.images[0]" :title="response.title" :description="response.description" :url="url" :video="response.video!==undefined ? response.video : undefined">

                <div class="post-video">
                    <div class="embed-responsive embed-responsive-16by9" v-if="response.video!==undefined" v-html="response.video"></div>
                    <div class="video-thumb full-width" v-else>
                        <img :src="response.images[0]">
                    </div>

                    <div class="video-content">
                        <h1><a v-bind:href="url" class="h4 title">{{response.title}}</a></h1>
                        <p>{{response.description}}</p>
                    </div>
                </div>

            </slot>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'link-preview',
        props: {
            url: {
                type: String,
                default: ''
            }
        },
        watch: {
            url: function(value) {
                this.response = null
                this.getLinkPreview()
            }
        },
        created() {
            this.getLinkPreview()
        },
        data: function() {
            return {
                response: null,
                validUrl: false
            }
        },
        methods: {
            isValidUrl: function(url) {
                const regex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/
                this.validUrl = regex.test(url)
                return this.validUrl
            },
            getLinkPreview: function() {
                if (this.isValidUrl(this.url)) {
                    axios.get('/helpers/link_preview', {
                        params: {
                            url: this.url
                        },
                    }).then(({ data }) => {
                        this.response = data;

                        if(data.title!=undefined)
                        {
                            data.img = data.images[0];
                            //delete data.images;
                            this.$emit('newLinkParsed', data);
                        }
                    }).catch(function (error) {
                        this.response = null
                        this.validUrl = false
                    });
                }
            }
        }
    }
</script>

<style scoped>
    /* Loader */
    .spinner {
        margin-top: 40%;
        margin-left: 45%;
        height: 28px;
        width: 28px;
        animation: rotate 0.8s infinite linear;
        border: 5px solid #868686;
        border-right-color: transparent;
        border-radius: 50%;
    }

    @keyframes rotate {
        0%    { transform: rotate(0deg); }
        100%  { transform: rotate(360deg); }
    }
</style>
