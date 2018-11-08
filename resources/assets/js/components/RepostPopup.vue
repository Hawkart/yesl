<template>
    <div class="modal fade" id="repost-dialog-form" tabindex="-1" role="dialog" aria-labelledby="repost-dialog-form" aria-hidden="true">
        <div class="modal-dialog window-popup repost-dialog-form" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Repost</h6>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="sendMessage" @keydown="form.onKeydown($event)" v-if="!hide_form">

                        <alert-errors :form="form"/>

                        <div class="form-group label-floating is-empty mb-0">
                            <div class="radio">
                                <label>
                                    <input type="radio" v-model="type" name="type" value="0">
                                    Post on the wall
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" v-model="type" name="type" value="1">
                                    Sent by private message
                                </label>
                            </div>
                        </div>

                        <div class="form-group label-floating is-empty mb-0">
                            <label class="control-label">Write your message here...</label>
                            <textarea class="form-control" placeholder="" v-model="form.text"
                                      :class="{ 'is-invalid': form.errors.has('message') }"></textarea>

                            <has-error :form="form" field="text"/>
                        </div>

                        <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">
                            Repost
                        </v-button>

                    </form>

                    <p v-else>Your repost has been successfully sent!</p>
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

        components: {
            Form, VButton
        },

        data: () => ({
            form: new Form({
                text: '',
                parent_id: 0,
                group_id: 0
            }),
            message: '',
            hide_form: false,
            type: 0
        }),

        created() {

            Event.listen("SetRepostPopup", (post) => {
                this.hide_form = false;
                this.form.parent_id = post.id;
            })
        },

        methods: {
            sendMessage()
            {
                if(this.type==0)
                {
                    this.form.post('/posts')
                        .then(({ data }) => {
                            this.hide_form = true;
                            this.form.reset();
                        })
                }else{

                }

            }
        }
    }
</script>