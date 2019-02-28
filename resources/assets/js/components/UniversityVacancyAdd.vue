<template>
    <div class="modal fade" id="create-university-vacancy" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                </a>
                <div class="modal-header">
                    <h6 class="title">Players Needed</h6>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">

                        <div class="col-12 col-xl-12 col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group label-floating is-select" v-if="games">
                                <label class="control-label">Game</label>
                                <select v-model="form.game_id" name="game_id" class="selectpicker form-control"  :class="{ 'is-invalid': form.errors.has('game_id') }">
                                    <option :value="game.id" v-for="game in games">{{game.title}}</option>
                                </select>
                                <has-error :form="form" field="game_id"/>
                            </div>
                        </div>

                        <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <v-button :loading="form.busy" type="primary" :large="true" additional="full-width mb-2">Save</v-button>

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
        props: ['games'],
        data : function() {
            return {
                form: new Form({
                    game_id: this.games!=null ? this.games[0].id : 0,
                }),
                university: {},
                message: ''
            }
        },
        created(){
            Event.listen('UniversityVacancyAddModalOpen', (data) => {
                this.university = data.university;
            });
        },

        methods : {
            save()
            {
                this.form.post('/universities/'+this.university.id+'/vacancies')
                    .then(({ data }) => {
                        this.message = data.message;
                        this.form.reset();

                        Event.fire("UniversityVacancyNew", data.data);
                    })
            }
        }
    }
</script>
