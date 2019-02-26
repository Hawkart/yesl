<template>
    <div class="modal fade" id="edit-university-teams" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                </a>
                <div class="modal-header">
                    <h6 class="title">Edit team</h6>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                        <div>
                            <alert-errors :form="form"/>
                            <alert-success :form="form" :message="message"/>
                        </div>
                        <div class="row ml-0 mr-0" v-if="team.game!=undefined">
                            <div class="col col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="ui-block">
                                    <article class="hentry blog-post" data-mh="choose-item">
                                        <div class="post-thumb">
                                            <img :src="getImageLink(team.game.logo)" :alt="team.game.title">
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="col col-xl-8 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="checkbox">
                                    <label>
                                        Players needed?
                                        <input type="checkbox" v-model="form.players_needed">
                                    </label>
                                </div>

                                <v-button :loading="form.busy" type="primary" :large="false" additional="full-width btn-xs mb-0">Update</v-button>
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
                    players_needed: false,
                }),
                team: {},
                message: ''
            }
        },
        mounted(){
        },
        created(){
            Event.listen('UniversityTeamEditModalOpen', (data) => {
                this.team = data.team;
                this.form.players_needed = data.team.players_needed;

                this.$nextTick(function () {
                    this.materialInit();
                });
            });
        },

        methods : {
            save()
            {
                this.form.patch('/teams/'+this.team.id)
                    .then(({ data }) => {
                        this.team = data.data;
                        this.message = data.message;
                        this.form.reset()

                        Event.fire("UniversityTeamEdit", this.team);
                    })
            }
        }
    }
</script>
