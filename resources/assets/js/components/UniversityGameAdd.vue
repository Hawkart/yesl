<template>
    <div class="modal fade" id="create-university-team" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                </a>
                <div class="modal-header">
                    <h6 class="title">Add college's team</h6>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                        <div id="game-list-container" v-if="games!=null && games.length>0">
                            <div class="choose-photo-item game-choose" data-mh="choose-item" v-if="!gamesIds.includes(game.id)"  v-for="game in games">
                                <div class="checkbox">
                                    <label>
                                        <img :src="getImageLink(game.logo)" :alt="game.title">
                                        <input type="checkbox" v-model="form.games" :value="game.id">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <v-button :loading="form.busy" type="primary" :large="true" additional="full-width">Save</v-button>

                            <alert-errors :form="form"/>
                            <alert-success :form="form" :message="message"/>
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
                        ids.push(team.id);
                    });
                }

                return ids;
            }
        },
        data : function() {
            return {
                form: new Form({
                    games: [],
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
            Event.listen('UniversityGameAddModalOpen', (data) => {
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
                this.form.post('/universities/'+this.university.id+'/games')
                    .then(({ data }) => {
                        this.teams = data.data;
                        this.message = data.message;
                        this.form.reset()

                        Event.fire("UniversityGameNew", this.teams);
                    })
            }
        }
    }
</script>
