<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Resume</h6>
        </div>
        <div class="ui-block-content">

            <form class="form-horizontal mt-10" @submit.prevent="update" @keydown="form.onKeydown($event)">
                <div class="row">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 lk-avatar">
                        <avatar-upload :uimg="user.avatar" uploadapi="/users/avatar" dataname="avatar"></avatar-upload>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.description=='' }">
                            <label class="control-label">Summary about yourself</label>
                            <textarea v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" type="text" name="description"></textarea>
                            <has-error :form="form" field="description"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.first_name=='' }">
                            <label class="control-label">First Name</label>
                            <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                            <has-error :form="form" field="first_name"/>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.last_name=='' }">
                            <label class="control-label">Last Name</label>
                            <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
                            <has-error :form="form" field="last_name"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating" :class="{ 'is-empty': form.second_name=='' }">
                            <label class="control-label">Middle Name</label>
                            <input v-model="form.second_name" :class="{ 'is-invalid': form.errors.has('second_name') }" class="form-control" type="text" name="second_name">
                            <has-error :form="form" field="second_name"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating" :class="{ 'is-empty': form.discord_nickname=='' }">
                            <label class="control-label">Discord username</label>
                            <input v-model="form.discord_nickname" :class="{ 'is-invalid': form.errors.has('discord_nickname') }" class="form-control" type="text" name="discord_nickname">
                            <has-error :form="form" field="discord_nickname"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.email=='' }">
                            <label class="control-label">Primary Email</label>
                            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" disabled="disabled" name="email">
                            <has-error :form="form" field="email"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating" :class="{ 'is-empty': form.phone=='' }">
                            <label class="control-label">Phone Number</label>
                            <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" class="form-control" type="text" name="phone">
                            <has-error :form="form" field="phone"/>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group label-floating">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_foreign"  v-model="form.is_foreign">
                                    Are you applying as an international student?
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.is_foreign">
                        <div class="form-group label-floating">
                            <label class="control-label">TOEFL paper</label>
                            <vue-numeric v-model="form.toefl_paper" :class="{ 'is-invalid': form.errors.has('toefl_paper') }" class="form-control" name="toefl_paper"></vue-numeric>
                            <has-error :form="form" field="toefl_paper"/>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.is_foreign">
                        <div class="form-group label-floating">
                            <label class="control-label">TOEFL computer based</label>
                            <vue-numeric v-model="form.toefl_computer" :class="{ 'is-invalid': form.errors.has('toefl_computer') }" class="form-control" name="toefl_computer"></vue-numeric>
                            <has-error :form="form" field="toefl_computer"/>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.is_foreign">
                        <div class="form-group label-floating">
                            <label class="control-label">TOEFL internet</label>
                            <vue-numeric v-model="form.toefl_internet" :class="{ 'is-invalid': form.errors.has('toefl_internet') }" class="form-control" name="toefl_internet"></vue-numeric>
                            <has-error :form="form" field="toefl_internet"/>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group inline-items required">
                            <label class="control-label">I am applying as:</label>
                            <div class="radio mb-0" v-for="apply_as in apply_list">
                                <label><input type="radio" v-model="form.apply_as" name="apply_as" :value="apply_as.value">{{apply_as.title}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.apply_as==0">
                        <div class="form-group label-floating">
                            <label class="control-label">ACT scores</label>
                            <vue-numeric v-model="form.act_scored" :class="{ 'is-invalid': form.errors.has('act_scored') }" class="form-control" name="act_scored"></vue-numeric>
                            <has-error :form="form" field="act_scored"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.apply_as==0">
                        <div class="form-group label-floating">
                            <label class="control-label">SAT scores</label>
                            <vue-numeric v-model="form.sat_scored" :class="{ 'is-invalid': form.errors.has('sat_scored') }" class="form-control" name="sat_scored"></vue-numeric>
                            <has-error :form="form" field="sat_scored"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.apply_as==1">
                        <div class="form-group label-floating">
                            <label class="control-label">Transferable college credit hours</label>
                            <vue-numeric v-model="form.transfer_hours" :class="{ 'is-invalid': form.errors.has('transfer_hours') }" class="form-control" name="transfer_hours"></vue-numeric>
                            <has-error :form="form" field="transfer_hours"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="form.apply_as==0 || form.apply_as==1">
                        <div class="form-group label-floating required">
                            <label class="control-label">GPA</label>
                            <vue-numeric v-bind:precision="2" v-model="form.gpa" :class="{ 'is-invalid': form.errors.has('gpa') }" class="form-control" name="gpa"></vue-numeric>
                            <has-error :form="form" field="gpa"/>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h6>Mailing Address:</h6>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required">
                            <label class="control-label">Country</label>
                            <select v-model="form.country" name="country" class="form-control"  :class="{ 'is-invalid': form.errors.has('country') }" @change="selectCountry">
                                <option :value="value" v-for="(title, value) in countries">{{title}}</option>
                            </select>
                            <has-error :form="form" field="country"/>
                        </div>
                    </div>

                    <div class="col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12" v-if="Object.keys(states).length>0">
                        <div class="form-group label-floating required">
                            <label class="control-label">State</label>
                            <select v-model="form.state" name="state" class="form-control"  :class="{ 'is-invalid': form.errors.has('state') }">
                                <option :value="value" v-for="(title, value) in states">{{title}}</option>
                            </select>
                            <has-error :form="form" field="state"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.street=='' }">
                            <label class="control-label">Street</label>
                            <input v-model="form.street" :class="{ 'is-invalid': form.errors.has('street') }" class="form-control" type="text" name="street">
                            <has-error :form="form" field="street"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.city=='' }">
                            <label class="control-label">City</label>
                            <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
                            <has-error :form="form" field="city"/>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group label-floating required" :class="{ 'is-empty': form.postal_code=='' }">
                            <label class="control-label">Postal Code</label>
                            <input v-model="form.postal_code" :class="{ 'is-invalid': form.errors.has('postal_code') }" class="form-control" type="text" name="postal_code">
                            <has-error :form="form" field="postal_code"/>
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
                email: '',
                discord_nickname: '',
                phone: '',
                is_foreign: false,
                apply_as: 0,
                act_scored: '',
                sat_scored: '',
                gpa: '',
                transfer_hours: '',
                toefl_paper: '',
                toefl_computer: '',
                toefl_internet: '',
                country: '',
                street: '',
                city: '',
                state: '',
                postal_code: '',
                description: ''
            }),
            apply_list:[
                {
                    value: 0,
                    title: 'First-Year'
                },
                {
                    value: 1,
                    title: 'Transfer'
                }
            ],
            countries: {},
            states: {},
            message: null
        }),
        created () {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                if(this.form[key]!=undefined)
                    this.form[key] = this.user[key];
            });

            if(this.form.country==null || this.form.country===undefined)
                this.form.country = 'US';

            //if(this.form.apply_as===undefined)
                //this.form.apply_as = 0;
        },
        mounted(){
            this.getCountries();
            this.getStates(this.form.country);
        },
        methods: {
            update()
            {
                this.form.patch('/users')
                    .then(({ data }) => {
                        this.message = data.message;
                    })
            },
            getCountries()
            {
                axios.get('/countries').then((response) => {
                    this.$set(this, 'countries', response.data);
                });
            },
            selectCountry(event)
            {
                this.getStates(event.target.value);
            },
            getStates(country)
            {
                axios.get('/countries/'+country+'/states').then((response) => {
                    this.$set(this, 'states', response.data);

                    this.$nextTick(function () {
                        this.materialInit();
                    });
                });
            },
        }
    }
</script>

