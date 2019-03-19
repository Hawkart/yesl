<template>
    <div class="modal fade" id="apply-modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Apply to team <span v-if="team.game!==undefined">{{team.game.title}}</span></h6>
                </div>
                <div class="modal-body" v-if="profiles!==undefined && profiles.length>0">

                    <div class="alert alert-danger" role="alert" v-if="!checkProfile() || !user.description">
                        <span v-if="!checkProfile() && team.game!==undefined">
                            You need to create {{team.game.title}} <a href="/settings/profiles" class="alert-link">Gamer Profile</a>
                        </span>

                        <span v-if="!user.description">
                            You need to fill <a href="/settings" class="alert-link">Resume</a>.
                        </span>
                    </div>

                    <form @submit.prevent="apply" @keydown="form.onKeydown($event)" v-else>

                        <p>
                            The coach of the university will receive your application:<br>
                            1. <a href="/settings" class="alert-link">Resume</a><br/>
                            2. <a href="/settings/profiles" class="alert-link">Gamer Profile</a>
                        </p>


                        <div class="form-group label-floating is-empty mb-0">
                            <label class="control-label">Message to coach...</label>
                            <textarea class="form-control" placeholder="" v-model="form.message"
                                      :class="{ 'is-invalid': form.errors.has('message') }"></textarea>

                            <has-error :form="form" field="message"/>
                        </div>

                        <div class="mt-2">
                            <v-button :loading="form.busy" type="primary" :large="true" additional="full-width mb-0">Apply</v-button>

                            <alert-errors :form="form" class="mt-2"/>
                            <alert-success :form="form" :message="message" class="mt-2"/>
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
    import VButton from "./Button"

    export default {
        props: ['user'],

        components: {
            Form, VButton
        },

        data: () => ({
            form: new Form({
                message: '',
                team_id: 0,
                user_id: 0,
                profile_id: 0
            }),
            message: '',
            team: [],
            profiles: []
        }),

        created() {

            this.getGamerProfiles();

            Event.listen("ApplyModalOpen", (data) => {
                this.team = data.team;
            });
        },

        methods: {
            getGamerProfiles()
            {
                axios.get('/users/'+this.user.id+'/profiles').then((response) => {
                    this.$set(this, 'profiles', response.data);
                });
            },
            checkProfile()
            {
                var ids = [];

                if(this.profiles.length>0)
                {
                    this.profiles.forEach(function(profile) {
                        ids.push(profile.game_id);
                    });
                }

                return ids.includes(this.team.game_id)
            },
            apply()
            {
                this.profiles.forEach((profile) => {
                    if(profile.game_id==this.team.game_id)
                        this.form.profile_id = profile.id;
                });

                this.form.team_id = this.team.id;
                this.form.user_id = this.user.id;

                this.form.post('/applications')
                    .then(({ data }) => {
                        this.message = data.message;
                        this.form.reset()
                    })
            }
        }
    }
</script>
