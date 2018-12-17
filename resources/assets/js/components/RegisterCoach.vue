<template>
    <div class="registration-login-form">

        <div class="title h6">Register as Coach</div>

        <alert-success :form="form"></alert-success>
        <alert-error :form="form"></alert-error>

        <form @submit.prevent="register" @keydown="form.onKeydown($event)" v-if="!confirmation_sent" aria-label="Register" class="content">
            <div class="row">
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
                        <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" required>
                        <has-error :form="form" field="email"/>
                    </div>
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Password</label>
                        <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password" required>
                        <has-error :form="form" field="password"/>
                    </div>
                </div>
                <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group date-time-picker label-floating">
                        <label class="control-label">Your Birthday</label>
                        <input v-model="form.date_birth" :class="{ 'is-invalid': form.errors.has('date_birth') }" type="text" name="date_birth" required>
                        <span class="input-group-addon">
                            <svg class="olymp-calendar-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-calendar-icon"></use></svg>
                        </span>
                        <has-error :form="form" field="date_birth"/>
                    </div>
                </div>
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
                    <div class="form-group label-floating">
                        <checkbox v-model="form.terms" name="terms" :class="{ 'is-invalid': form.errors.has('terms') }">
                            I accept the <a href="/terms">Terms and Conditions</a> of the website
                        </checkbox>
                        <has-error :form="form" field="terms"/>
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
                date_birth: '',
                gender: 0,
                password: '',
                terms: true
            }),
            confirmation_sent: false,
            genders: [
                {'value': 0, 'title': 'Male'},
                {'value': 1, 'title': 'Female'},
            ],
        }),
        mounted() {

        },
        methods: {
            async register () {
                const { data } = await this.form.post('/register');
                this.confirmation_sent = true;
            }
        }
    }
</script>