<template>
    <div>
        <alert-errors :form="form"/>

        <form @submit.prevent="sendMessage" @keydown="form.onKeydown($event)">

            <div class="form-group label-floating is-empty mb-0">
                <label class="control-label">Write your reply here...</label>
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
                    Post Reply
                </v-button>
            </div>

        </form>
    </div>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "./Button"

    export default {
        props: ['activeChannel', 'user'],

        components: {
            Form, VButton
        },

        data: () => ({
            form: new Form({
                message: ''
            }),
            message: ''
        }),

        methods: {
            newline() {
                this.form.message = `${this.form.message}\n`;
            },
            sendMessage()
            {
                var thread_id = 0;
                if(this.activeChannel.is_user)
                {
                    this.form.participants = [this.activeChannel.participant.id];
                }else{
                    thread_id = this.activeChannel.id;
                }

                if(this.form.message!="" && !this.form.busy)
                {
                    this.form.post('/channels/'+thread_id+'/messages').then((response) => {
                        this.$emit('messageAdded', response.data);
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