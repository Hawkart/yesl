<template>
    <form @submit.prevent="save" @keydown="form.onKeydown($event)" class="comment-form inline-items">

        <alert-success :form="form" :message="message" class="w-100"/>

        <div class="post__author author vcard inline-items">
            <img :src="getImageLink(user.avatar)" :alt="user.name" width="36">

            <div class="form-group with-icon-right">
                <textarea v-model="form.comment" :class="{ 'is-invalid': form.errors.has('comment') }" name="comment" class="form-control" placeholder="Add the comment..."></textarea>
                <has-error :form="form" field="comment"/>
                <div class="add-options-message">
                    <a href="#" class="options-message" data-toggle="modal" data-target="#update-header-photo">
                        <svg class="olymp-camera-icon">
                            <use xlink:href="/svg-icons/sprites/icons.svg#olymp-camera-icon"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post Comment</v-button>
    </form>
</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import VueEmoji from 'emoji-vue'

    export default {
        components: {VButton, VueEmoji},
        props: ['post_id', 'user', 'reply_id'],
        data: () => ({
            form: new Form({
                comment: ''
            }),
            message: null,
            comment: ''
        }),
        methods: {
            save()
            {
                this.form.post_id = this.post_id;
                this.form.reply_id = this.reply_id;

                this.form.post('/comments')
                    .then(({ data }) => {
                        this.message = data.message;
                        Event.fire("CommentNew"+this.post_id, data.data);
                        this.form.reset();
                    })
            },
            onInput(event) {
                this.form.comment = event.data;
            }
        }
    }
</script>