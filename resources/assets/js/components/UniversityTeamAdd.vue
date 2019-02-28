<template>
    <div class="modal fade" id="create-university-teams" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                </a>
                <div class="modal-header">
                    <h6 class="title">Create university's/college's teams</h6>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                        <div id="game-list-container" v-if="games!=null && games.length>0">

                            <div class="row ml-0 mr-0" v-if="!gamesIds.includes(game.id)" v-for="game in games">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="ui-block">
                                        <article class="hentry blog-post" data-mh="choose-item">
                                            <div class="post-thumb">
                                                <img :src="getImageLink(game.logo)" :alt="game.title">
                                            </div>
                                        </article>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="form.games" :value="game.id">
                                            Current or future team
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="form.vacancies" :value="game.id">
                                            Now recruiting to this team
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <v-button :loading="form.busy" type="primary" :large="true" additional="full-width mb-0">Save</v-button>

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
    import VButton from "./Button";

    export default {
        components: {VButton},
        computed: {
            gamesIds: function(){
                var ids=[];

                if(this.teams.length>0)
                {
                    this.teams.forEach(function addNumber(team) {
                        ids.push(team.game_id);
                    });
                }

                return ids;
            }
        },
        data : function() {
            return {
                form: new Form({
                    games: [],
                    vacancies: [],
                }),
                games: [],
                teams: {},
                university: {},
                message: ''
            }
        },
        mounted(){
            this.getGames();
        },
        created(){
            Event.listen('UniversityTeamAddModalOpen', (data) => {
                this.teams = data.teams;
                this.university = data.university;
            });
        },

        methods : {
            getGames: function()
            {
                axios.get('/rest/games').then((response) => {
                    this.$set(this, 'games', response.data);

                    this.$nextTick(function () {
                        $('#game-list-container').perfectScrollbar({wheelPropagation:false});
                        this.materialInit();
                    });
                });
            },
            save()
            {
                this.form.post('/universities/'+this.university.id+'/teams')
                    .then(({ data }) => {
                        this.teams = data.data;
                        this.message = data.message;
                        this.form.reset()

                        Event.fire("UniversityTeamNew", this.teams);
                    })
            }
        }
    }
</script>
