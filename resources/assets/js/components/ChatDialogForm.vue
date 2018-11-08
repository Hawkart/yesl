<template>
    <div class="modal fade" id="chat-dialog-form" tabindex="-1" role="dialog" aria-labelledby="chat-dialog-form" aria-hidden="true">
        <div class="modal-dialog window-popup chat-dialog-form" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Chat</h6>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="sendMessage" @keydown="form.onKeydown($event)" v-if="!hide_form">

                        <alert-errors :form="form"/>

                        <div class="form-group label-floating is-empty mb-0">
                            <label class="control-label">Write your message here...</label>
                            <textarea class="form-control" placeholder="" v-model="form.message"
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
                this.form.participants = [participant.id];
            })
        },

        methods: {
            sendMessage()
            {
                if(this.form.message!="" && !this.form.busy)
                {
                    this.form.post('/channels/0/messages').then((response) => {
                        this.hide_form = true;
                        this.form.reset();
                    });
                }
            }
        }
    }
</script>