<template>
    <div>
        <p>{{description}}</p>

        <a href="#" data-toggle="modal" data-target="#edit-group" class="btn btn-primary btn-sm full-width mt-2" v-if="group.owner_id==user.id">
            Edit
        </a>

        <div class="modal fade" id="edit-group" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
            <div class="modal-dialog window-popup choose-from-my-photo" role="document">

                <div class="modal-content">
                    <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                        <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                    </a>
                    <div class="modal-header">
                        <h6 class="title">Edit a group</h6>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="save" @keydown="form.onKeydown($event)" aria-label="Register" class="content">
                            <div class="row">
                                <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group required" :class="{ 'is-empty': form.description=='' }">
                                        <label class="control-label">Description</label>
                                        <textarea v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" type="text" name="description"></textarea>
                                        <has-error :form="form" field="description"/>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-12">
                                    <v-button :loading="form.busy" type="primary" :large="true" additional="full-width mb-0">Save</v-button>

                                    <alert-errors :form="form" class="mt-2"/>
                                    <alert-success :form="form" :message="message" class="mt-2"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "./Button";

    export default {
        props: ['group', 'user'],
        components: {VButton},
        data : function() {
            return {
                form: new Form({
                    description: null,
                }),
                description: null,
                message: ''
            }
        },
        mounted(){},
        created(){
            this.form.description = this.group.description;
            this.description = this.group.description;
        },
        methods : {
            save()
            {
                this.form.patch('/groups/'+this.group.id)
                    .then(({ data }) => {
                        this.message = data.message;
                        //this.form.reset();
                        this.description = this.form.description
                    })
            }
        }
    }
</script>
