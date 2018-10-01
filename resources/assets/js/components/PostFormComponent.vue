<template>

    <div class="news-feed-form">
        <alert-success :form="form" :message="message"/>
        <form @submit.prevent="save" @keydown="form.onKeydown($event)">
            <div class="author-thumb">
                <img :src="getImageLink(user.avatar)" :alt="user.name" width="36">
            </div>
            <!--<div class="form-group with-icon label-floating">-->
            <div class="form-group label-floating">
                <VueEmoji @input="onInput" height="100" :value="form.text" :class="{ 'is-invalid': form.errors.has('text') }" class="form-control" placeholder="Share what you are thinking here..."/>
                <has-error :form="form" field="text"/>
            </div>
            <div class="add-options-message">
                <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD PHOTOS">
                    <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-camera-icon"></use></svg>
                </a>
                <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="TAG YOUR FRIENDS">
                    <svg class="olymp-computer-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-computer-icon"></use></svg>
                </a>

                <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD LOCATION">
                    <svg class="olymp-small-pin-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-small-pin-icon"></use></svg>
                </a>

                <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post</v-button>
            </div>
        </form>

        <!--<form @submit.prevent="save" @keydown="form.onKeydown($event)"  class="comment-form inline-items">
            <alert-success :form="form" :message="message"/>
            <div class="post__author author vcard inline-items">
                <img :src="getImageLink(user.avatar)" :alt="user.name" width="36">

                <div class="form-group">
                    <textarea v-model="form.text" class="form-control" placeholder=""></textarea>

                    <div class="add-options-message">
                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD PHOTOS">
                            <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-camera-icon"></use></svg>
                        </a>
                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="TAG YOUR FRIENDS">
                            <svg class="olymp-computer-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-computer-icon"></use></svg>
                        </a>

                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD LOCATION">
                            <svg class="olymp-small-pin-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-small-pin-icon"></use></svg>
                        </a>
                    </div>
                </div>
            </div>

            <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post</v-button>
        </form>-->
    </div>


</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import VueEmoji from 'emoji-vue'

    export default {
        components: {VButton, VueEmoji},
        props: ['group_id', 'user'],
        data: () => ({
            form: new Form({
                text: ''
            }),
            message: null,
            text: ''
        }),
        methods: {
            save()
            {
                this.form.group_id = this.group_id;

                this.form.post('/posts')
                    .then(({ data }) => {
                        this.message = data.message;
                        Event.fire("PostNew"+this.group_id, data.data);
                        this.form.reset();
                    })
            },
            onInput(event) {
                this.form.text = event.data;
            }
        }
    }
</script>