<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Edit gamer profile</h6>

            <div class="align-right">
                <a href="/settings/profiles" class="btn btn-primary btn-md-2">Back to Gamer Profiles list</a>
            </div>
        </div>

        <div class="ui-block-content">
            <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group required">
                        <label class="control-label">What esport are you interest in?</label>
                        <select v-model="form.game_id" disabled name="game_id" class="form-control"  :class="{ 'is-invalid': form.errors.has('game_id') }" @change="selectGame">
                            <option :value="game.id" v-for="game in games">{{game.title}}</option>
                        </select>
                        <has-error :form="form" field="game_id"/>
                    </div>
                </div>

                <div v-if="game.id!==undefined">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group required">
                            <label class="control-label">What is your Name in {{game.title}}?</label>
                            <input v-model="form.nickname" :class="{ 'is-invalid': form.errors.has('nickname') }" class="form-control" type="text" name="nickname">
                            <has-error :form="form" field="nickname"/>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group required">
                            <label class="control-label">What is your current rank in {{game.rank_in}}?</label>
                            <input v-model="form.rank" :class="{ 'is-invalid': form.errors.has('rank') }" class="form-control" type="text" name="rank">
                            <has-error :form="form" field="rank"/>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">What was your peak rank for this or past season?</label>
                            <input v-model="form.peak_rank" :class="{ 'is-invalid': form.errors.has('peak_rank') }" class="form-control" type="text" name="peak_rank">
                            <has-error :form="form" field="peak_rank"/>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group required">
                            <label class="control-label">Add the link to your {{game.main_profile_name}} profile</label>
                            <input v-model="form.link" :class="{ 'is-invalid': form.errors.has('link') }" class="form-control" type="text" name="link">
                            <has-error :form="form" field="link"/>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Add the link to any other ranked gamer profile. For example {{game.additional_profile_name}} </label>
                            <input v-model="form.additional_link" :class="{ 'is-invalid': form.errors.has('additional_link') }" class="form-control" type="text" name="additional_link">
                            <has-error :form="form" field="additional_link"/>
                        </div>
                    </div>


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                        <h6>List any tournaments you have competed in and what you placed:</h6>

                        <div v-for="(tournament, index) in tournaments" class="mb-3">

                            <div class="row ml-0 mr-0" style="border: 1px solid #e6ecf5; padding: 20px; position: relative">
                                <div class="close icon-close" style="position: absolute; right: 7px; top: 5px; margin:0;">
                                    <a href="#" @click.prevent="removeTournament(index)">
                                        <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                                    </a>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Month</label>
                                        <input v-model="tournament.month" type="number"
                                               name="tournaments[][month]" class="form-control" placeholder="Month">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Year</label>
                                        <input v-model="tournament.year" type="number"
                                               name="tournaments[][year]" class="form-control" placeholder="Year">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Tournament title</label>
                                        <input v-model="tournament.title" type="text"
                                               name="tournaments[][title]" class="form-control" placeholder="Tournament title">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Team</label>
                                        <input v-model="tournament.team" type="text"
                                               name="tournaments[][team]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group inline-items">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="radio mb-0" v-for="lradio in lan_online">
                                            <label><input type="radio" v-model="tournament.is_lan" name="tournaments[][is_lan]" :value="lradio.value">{{lradio.title}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="tournament.is_lan==1">
                                    <div class="form-group">
                                        <label class="control-label">Place of tournament</label>
                                        <input v-model="tournament.location" type="text"
                                               name="tournaments[][location]" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Organizer Name</label>
                                        <input v-model="tournament.org_name" type="text"
                                               name="tournaments[][org_name]" class="form-control" placeholder="Organizer Name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Link to Organizer website</label>
                                        <input v-model="tournament.org_link_site" type="text"
                                               name="tournaments[][org_link_site]" class="form-control" placeholder="Link to Organizer website">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Your Place</label>
                                        <input v-model="tournament.place" type="text"
                                               name="tournaments[][place]" class="form-control" placeholder="Your Place">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Link to the webpage with confirmation of your place</label>
                                        <input v-model="tournament.place_confirm_link" type="text"
                                               name="tournaments[][place_confirm_link]" class="form-control" placeholder="Link to the webpage with confirmation of your place">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button type="button" v-on:click="addNewTournament" class="btn btn-md-2 full-width btn-success">
                            Add tournament experience +
                        </button>

                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Add the link to your streaming (Twitch/Mixer/ etc.) Account</label>
                            <input v-model="form.streaming_link" :class="{ 'is-invalid': form.errors.has('streaming_link') }" class="form-control" type="text" name="streaming_link">
                            <has-error :form="form" field="streaming_link"/>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                        <div class="form-group inline-items required">
                            <label class="control-label">Have you been banned by {{game.dev_company}}?</label>
                            <div class="radio mb-0" v-for="banned_answer in banned_list">
                                <label><input type="radio" v-model="form.have_banned" name="have_banned" :value="banned_answer.value">{{banned_answer.title}}</label>
                            </div>

                            <has-error :form="form" field="have_banned" class="d-block"/>
                        </div>
                    </div>
                    <v-button :loading="form.busy" type="primary" :large="true" additional="full-width mb-0">Save</v-button>

                    <alert-errors :form="form" class="mt-2"/>
                    <alert-success :form="form" :message="message" class="mt-2"/>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "../Button";

    export default {
        components: {VButton},
        props: ['url', 'profile'],
        data : function() {
            return {
                form: new Form({
                    game_id: 0,
                    nickname: '',
                    rank: '',
                    peak_rank: '',
                    link: '',
                    additional_link: '',
                    progress: '',
                    streaming_link: '',
                    have_banned: '',
                }),
                games: [],
                game: [],
                teams: {},
                university: {},
                message: '',
                banned_list:[
                    {
                        value: 1,
                        title: 'Yes'
                    },
                    {
                        value: 0,
                        title: 'No'
                    }
                ],
                lan_online: [
                    {
                        value: 1,
                        title: 'LAN'
                    },
                    {
                        value: 2,
                        title: 'Online'
                    }
                ],
                tournament: {
                    month: '',
                    year: '',
                    title: '',
                    is_lan: false,
                    location: '',
                    org_name: '',
                    org_link_site: '',
                    team: '',
                    place: '',
                    place_confirm_link: ''
                },
                tournaments: [],
            }
        },
        created(){
            this.getGames();

            // Fill the form with user data.
            this.form.keys().forEach(key => {
                this.form[key] = this.profile[key];
            });

            this.tournaments = this.profile.progress;

            this.getGame(this.profile.game_id);
        },
        methods : {
            getGames()
            {
                axios.get('/rest/games').then((response) => {
                    this.$set(this, 'games', response.data);

                    this.$nextTick(function () {
                        this.materialInit();
                    });
                });
            },
            selectGame(event)
            {
                this.getGame(event.target.value);
            },
            getGame(id)
            {
                axios.get('/rest/games/'+id).then((response) => {
                    this.$set(this, 'game', response.data);

                    this.$nextTick(function () {
                        this.materialInit();
                    });
                });
            },
            addNewTournament: function () {
                this.tournaments.push(Vue.util.extend({}, this.tournament));
                this.$nextTick(function () {
                    this.materialInit();
                });
            },
            removeTournament: function (index) {
                Vue.delete(this.tournaments, index);
            },
            update()
            {
                this.form.progress = this.tournaments;

                this.form.patch(this.url)
                    .then(({ data }) => {
                        this.message = data.message;
                    })
            }
        }
    }
</script>
