<template>
    <div class="modal fade" id="create-group" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                </a>
                <div class="modal-header">
                    <h6 class="title">Create a group</h6>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" @keydown="form.onKeydown($event)" aria-label="Register" class="content">
                        <div class="row">
                            <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group required" :class="{ 'is-empty': form.title=='' }">
                                    <label class="control-label">Title</label>
                                    <input v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" class="form-control" type="text" name="title">
                                    <has-error :form="form" field="title"/>
                                </div>
                            </div>
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
</template>


<script>
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "./Button";

    export default {
        components: {VButton},
        data : function() {
            return {
                form: new Form({
                    title: null,
                    description: null,
                }),
                message: ''
            }
        },
        mounted(){},
        created(){},
        methods : {
            save()
            {
                this.form.post('/groups')
                    .then(({ data }) => {
                        this.message = data.message;
                        this.form.reset();

                        setTimeout(function(){
                            window.location.href = '/groups/'+data.data.slug;
                        }, 2000);
                    });
            }
        }
    }
</script>
