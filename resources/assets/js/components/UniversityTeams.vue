<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h2 class="title">Teams</h2>

            <div class="align-right" v-if="user.id==group.owner_id">
                <a href="#" @click="openModalForm" data-toggle="modal" data-target="#create-university-teams" class="btn btn-primary btn-md-2">Create team +</a>
            </div>
        </div>

        <div class="ui-block-content">
            <div class="row" v-if="message">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div role="alert" class="alert alert-success alert-dismissible">
                        <button type="button" aria-label="Close" class="close" @click.prevent="close"><span aria-hidden="true">×</span></button>
                        <div>{{message}}</div>
                    </div>
                </div>
            </div>

            <div v-if="teams">

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12"  v-for="team in teams" :key="team.id">
                        <div class="ui-block">
                            <article class="hentry blog-post" data-mh="choose-item">
                                <div class="post-thumb">
                                    <img :src="getImageLink(team.game.logo)" :alt="team.game.title">
                                    <a href="javascript:void(0)" class="bg-violet label-recruting" v-if="team.players_needed">Recruiting</a>
                                </div>
                                <div class="post-content pb-0">

                                    <!--<chat-dialog-button :participant='group.owner' :classes="'pa-0 mb-0 full-width'" v-if="team.players_needed && user.id!=group.owner_id && user.type==1">
                                        <button type="submit" class="btn btn-sm btn-primary full-width mt-0">Apply</button>
                                    </chat-dialog-button>-->

                                    <a href="#" @click="applyModalForm(team)"
                                       data-toggle="modal" data-target="#apply-modal-form"
                                       v-if="team.players_needed && user.id!=group.owner_id && user.type==1"
                                       class="btn btn-sm btn-primary full-width mt-0">Apply</a>

                                    <a href="#" @click.prevent="edit(team)" data-toggle="modal" data-target="#edit-university-teams" class="btn btn-primary btn-sm full-width"  v-if="user.id==group.owner_id">Edit</a>
                                    <a href="#" @click.prevent="del(team.id)" class="btn btn-grey-lighter btn-sm full-width"  v-if="user.id==group.owner_id">Delete</a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-1 text-center" v-else>
                University hasn't teams yet!
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['teams', 'university', 'group', 'user'],
        data: () => ({
            message: null
        }),
        created(){
            Event.listen('UniversityTeamNew', (teams) => {
                this.teams = teams;
            });

            Event.listen('UniversityTeamEdit', (team) => {

                var teams = this.teams.map(function (t) {
                    if(t.id==team.id) t = team;
                    return t;
                });

                this.teams = teams;
            });
        },
        methods: {
            openModalForm()
            {
                Event.fire("UniversityTeamAddModalOpen", {
                    'teams': this.teams,
                    'university': this.university
                });
            },
            applyModalForm(team)
            {
                Event.fire("ApplyModalOpen", {
                    'team': team
                });
            },
            del(id){

                axios.delete('/teams/'+id)
                    .then(({ data }) => {

                        this.message = data.message;

                        var teams = this.teams.filter(function(team) {
                            if(team.id!=id)
                                return true;

                            return false;
                        });

                        this.teams = teams;
                    })
            },
            edit(team)
            {
                Event.fire("UniversityTeamEditModalOpen", {
                    'team': team
                });
            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
