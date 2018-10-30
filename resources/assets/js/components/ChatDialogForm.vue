<template>
    <div class="ui-block popup-chat popup-chat-responsive modal fade" id="chat-dialog-form" tabindex="-1" role="dialog" aria-labelledby="chat-dialog-form" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <span class="icon-status online"></span>
                <h6 class="title" >Chat</h6>
                <div class="more">
                    <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
                    <svg class="olymp-little-delete js-chat-open"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-little-delete"></use></svg>
                </div>
            </div>
            <div class="modal-body">

                <form @submit.prevent="sendMessage" @keydown="form.onKeydown($event)" v-if="!hide_form">

                    <alert-errors :form="form"/>

                    <div class="form-group label-floating is-empty mb-0">
                        <label class="control-label">Write your message here...</label>
                        <textarea class="form-control" placeholder="" v-model="form.message"
                                  @keydown.enter.exact.prevent
                                  @keyup.enter.exact="sendMessage"
                                  @keydown.enter.shift.exact="newline"
                                  @keydown="actionUser"
                                  :class="{ 'is-invalid': form.errors.has('message') }"></textarea>

                        <has-error :form="form" field="message"/>
                    </div>

                    <div class="add-options-message border-0">
                        <v-button :loading="form.busy" type="primary" :large="false" additional="btn-sm">
                            Post message
                        </v-button>
                    </div>

                </form>

                <p v-else>Your message has been successfully sent!</p>
            </div>
        </div>
    </div>
</template>


<script>
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "./Button"

    export default {
        props: ['user'],

        components: {
            Form, VButton
        },

        data: () => ({
            form: new Form({
                message: '',
                participants: []
            }),
            message: '',
            hide_form: false
        }),

        created() {

            Event.listen("PrivateDialogMessage", (participant) => {
                this.hide_form = false;
                this.form.participants = participant.id;
            })
        },

        methods: {
            newline() {
                this.form.message = `${this.form.message}\r\n`;
            },
            sendMessage()
            {
                this.form.participants = [this.activeChannel.participant.id];
                if(this.form.message!="" && !this.form.busy)
                {
                    this.form.post('/channels/0/messages').then((response) => {
                        this.hide_form = true;
                        this.form.reset();
                    });
                }
            },
            actionUser()
            {
                if(!this.activeChannel.is_user) {
                    window.Echo.private("channel_" + this.activeChannel.id.toString())
                        .whisper('typing', {
                            'user': this.user
                        });
                }
            }
        }
    }
</script>