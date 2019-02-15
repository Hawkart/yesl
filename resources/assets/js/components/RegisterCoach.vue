<template>
    <div class="registration-login-form">

        <div class="title h6">Register as Coach</div>

        <form @submit.prevent="register" @keydown="form.onKeydown($event)" aria-label="Register" class="content">

            <alert-success :form="form">{{message}}</alert-success>

            <div class="row" v-if="!confirmation_sent">
                <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">First Name</label>
                        <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name" required>
                        <has-error :form="form" field="first_name"/>
                    </div>
                </div>
                <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Last Name</label>
                        <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name" required>
                        <has-error :form="form" field="last_name"/>
                    </div>
                </div>

                <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">E-mail Address</label>
                        <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" @blur="onEmailChange" class="form-control" type="email" name="email" required>
                        <has-error :form="form" field="email"/>
                    </div>
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Password</label>
                        <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password" required>
                        <has-error :form="form" field="password"/>
                    </div>
                </div>
                <!--<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group date-time-picker label-floating">
                        <label class="control-label">Your Birthday</label>
                        <datepicker v-model="form.date_birth" format="yyyy-MM-dd" :required="true" :class="{ 'is-invalid': form.errors.has('date_birth') }" name="date_birth"></datepicker>
                        <span class="input-group-addon">
                            <svg class="olymp-calendar-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-calendar-icon"></use></svg>
                        </span>
                        <has-error :form="form" field="date_birth"/>
                    </div>
                </div>-->
                <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group label-floating is-select">
                        <label class="control-label">Your Gender</label>
                        <select v-model="form.gender" name="gender" :class="{ 'is-invalid': form.errors.has('gender') }" class='selectpicker form-control'>
                            <option v-for="g in genders" v-bind:value="g.value">
                                {{ g.title }}
                            </option>
                        </select>
                        <has-error :form="form" field="gender"/>
                    </div>
                </div>
                <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    <span v-if="show_welcome"></span>

                    <div class="form-group">
                        <div class="w-select pa-0">
                            <fieldset class="form-group form-control pa-0" :class="{ 'is-invalid': form.errors.has('university_id') }">
                                <select v-model="form.university_id" name="university_id" id="university_list" class="w-100">
                                    <option :value="selected.id" selected="selected" v-if="selected!=null">{{selected.title}}</option>
                                </select>
                            </fieldset>
                            <has-error :form="form" field="university_id"/>
                        </div>
                    </div>
                    <!--
                    <div class="form-group label-floating is-select">
                        <label class="control-label">University</label>
                        <select v-model="form.university_id" name="university_id" :class="{ 'is-invalid': form.errors.has('university_id') }" class='selectpicker form-control'>
                            <option v-for="u in universities" v-bind:value="u.id">
                                {{ u.title }}
                            </option>
                        </select>
                        <has-error :form="form" field="university_id"/>
                    </div>
                    -->
                </div>
                <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group label-floating">
                        <checkbox v-model="form.terms" name="terms" :class="{ 'is-invalid': form.errors.has('terms') }">
                            I accept the <a href="/terms">Terms and Conditions</a> of the website
                        </checkbox>
                    </div>
                    <v-button :loading="form.busy" class="btn-lg full-width mb-0" id="btn-reg">
                        Register as Coach
                    </v-button>
                </div>
            </div>
        </form>
    </div>
</template>


<script>
    import Form from 'vform'
    import VButton from "./Button"
    import Checkbox from "./Checkbox"

    export default {
        components: {
            VButton,
            Checkbox
        },
        data: () => ({
            form: new Form({
                type: 2,
                first_name: '',
                last_name: '',
                email: '',
                //date_birth: '',
                gender: 0,
                password: '',
                terms: true,
                university_id: 0
            }),
            confirmation_sent: false,
            universities: null,
            selected: null,
            message: null,
            last_email:null,
            show_welcome: false,
            genders: [
                {'value': 0, 'title': 'Male'},
                {'value': 1, 'title': 'Female'},
            ],
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
        }),
        mounted() {
            Vue.nextTick(() => {
                this.getUniversities();
            });
        },
        methods: {
            isEmailValid(email) {
                return (email != "" && this.reg.test(email));
            },
            onEmailChange()
            {
                if(this.isEmailValid(this.form.email) && this.last_email!=this.form.email)
                {
                    axios.get('/universities?url='+this.form.email).then((response) => {
                        var data = response.data.data;

                        if(data.length>0){
                            this.form.university_id = data[0].id;
                            this.$set(this, 'selected', data[0]);
                            this.show_welcome = true;
                        }

                        this.last_email = this.form.email;
                    });
                }
            },
            getUniversities()
            {
                var self = this;
                $("#university_list").select2({
                    ajax: {
                        url: '/universities',
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
                    self.form.university_id = $(e.currentTarget).find("option:selected").val();
                });
            },
            async register () {
                const { data } = await this.form.post('/register');
                this.message = data.message;
                this.confirmation_sent = true;
            }
        }
    }
</script>
