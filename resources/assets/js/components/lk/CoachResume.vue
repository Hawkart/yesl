<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Resume</h6>
        </div>
        <div class="ui-block-content">

            <form class="form-horizontal mt-10" @submit.prevent="update" @keydown="form.onKeydown($event)">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <avatar-upload :uimg="user.avatar" uploadapi="/users/avatar" dataname="avatar"></avatar-upload>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group required" :class="{ 'is-empty': form.description=='' }">
                            <label class="control-label">Summary</label>
                            <textarea v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" type="text" name="description"></textarea>
                            <has-error :form="form" field="description"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group required" :class="{ 'is-empty': form.first_name=='' }">
                            <label class="control-label">First Name</label>
                            <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                            <has-error :form="form" field="first_name"/>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group required" :class="{ 'is-empty': form.last_name=='' }">
                            <label class="control-label">Last Name</label>
                            <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
                            <has-error :form="form" field="last_name"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group" :class="{ 'is-empty': form.second_name=='' }">
                            <label class="control-label">Middle Name</label>
                            <input v-model="form.second_name" :class="{ 'is-invalid': form.errors.has('second_name') }" class="form-control" type="text" name="second_name">
                            <has-error :form="form" field="second_name"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label d-block">Current college/university</label>
                            <span class="d-block mt-4" v-if="university">{{this.university.title}}</span>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group" :class="{ 'is-empty': form.title=='' }">
                            <label class="control-label">Title</label>
                            <input v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" class="form-control" type="text" name="title">
                            <has-error :form="form" field="title"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group" :class="{ 'is-empty': form.alma_mater=='' }">
                            <label class="control-label">Alma mater</label>
                            <div class="w-select pa-0">
                                <fieldset class="form-group form-control pa-0" :class="{ 'is-invalid': form.errors.has('alma_mater') }">
                                    <select v-model="form.alma_mater" name="alma_mater" id="university_list" class="w-100">
                                        <option :value="selected.id" selected="selected" v-if="selected!=null">{{selected.title}}</option>
                                    </select>
                                </fieldset>
                                <has-error :form="form" field="alma_mater"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Season in row</label>
                            <vue-numeric v-model="form.season_in_row" :class="{ 'is-invalid': form.errors.has('season_in_row') }" class="form-control" name="season_in_row"></vue-numeric>
                            <has-error :form="form" field="season_in_row"/>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h6>List your previous experience:</h6>

                        <div v-for="(experience, index) in experiences" class="mb-3">

                            <div class="row ml-0 mr-0" style="border: 1px solid #e6ecf5; padding: 20px; position: relative">
                                <div class="close icon-close" style="position: absolute; right: 7px; top: 5px; margin:0;">
                                    <a href="#" @click.prevent="removeTournament(index)">
                                        <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                                    </a>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Title</label>
                                        <input v-model="experience.title" type="text"
                                               name="experiences[][title]" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Company/University</label>
                                        <input v-model="experience.company" type="text"
                                               name="experiences[][company]" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Location</label>
                                        <input v-model="experience.location" type="text"
                                               name="experiences[][location]" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label d-block mt-5">From:</label>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Month</label>
                                        <input v-model="experience.month_from" type="number"
                                               name="experiences[][month_from]" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Year</label>
                                        <input v-model="experience.year_from" type="number"
                                               name="experiences[][year_from]" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label d-block mt-5">To:</label>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Month</label>
                                        <input v-model="experience.month_to" type="number"
                                               name="experiences[][month_to]" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Year</label>
                                        <input v-model="experience.year_to" type="number"
                                               name="experiences[][year_to]" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button type="button" v-on:click="addNewTournament" class="btn btn-md-2 full-width btn-success">
                            Add experience +
                        </button>

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
</template>


<script>
    import Form from 'vform'
    import VButton from "../Button";
    import VueNumeric from 'vue-numeric'

    export default {
        components: {VButton,VueNumeric},
        props: ['user'],
        data: () => ({
            form: new Form({
                first_name: '',
                last_name: '',
                second_name: '',
                description: '',
                title: '',
                season_in_row: 0,
                alma_mater: '',
                experience: ''
            }),
            universities: {},
            experience: {
                title: '',
                location: '',
                company: '',
                month_from: '',
                month_to: '',
                year_from: '',
                year_to: ''
            },
            experiences: [],
            university: {},
            selected: null,
            message: null
        }),
        created () {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                if(this.form[key]!=undefined)
                    this.form[key] = this.user[key];
            });

            if(this.user.experience)
                this.experiences = this.user.experience;
        },
        mounted(){
            Vue.nextTick(() => {
                this.getUniversities();

                if(this.user.alma_mater>0)
                    this.getUniversity(this.user.alma_mater, 'selected');
            });

            if(this.user.university_id>0)
                this.getUniversity(this.user.university_id, 'university');
        },
        methods: {
            update()
            {
                this.form.experience = this.experiences;

                this.form.patch('/users')
                    .then(({ data }) => {
                        this.message = data.message;
                    })
            },
            getUniversity(uid, svar)
            {
                axios.get('/rest/universities/'+uid).then((response) => {
                    this.$set(this, svar, response.data);
                });
            },
            getUniversities()
            {
                var self = this;
                $("#university_list").select2({
                    ajax: {
                        url: '/rest/universities',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                "title": params.term, // search term
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params)
                        {
                            params.page = params.page || 1;
                            self.$set(self, 'universities', data.data);

                            return {
                                results: data.data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.title
                                    };
                                }),
                                pagination: {
                                    more: (params.page * 50) < data.total
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    minimumInputLength: 3,
                    placeholder: 'Type to search university...'
                }).on("change", function (e) {
                    self.form.alma_mater = $(e.currentTarget).find("option:selected").val();
                });
            },
            addNewTournament: function () {
                this.experiences.push(Vue.util.extend({}, this.experience));
                this.$nextTick(function () {
                    this.materialInit();
                });
            },
            removeTournament: function (index) {
                Vue.delete(this.experiences, index);
            }
        }
    }
</script>
