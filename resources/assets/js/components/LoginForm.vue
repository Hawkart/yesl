<template>
    <div class="registration-login-form">

        <div class="title h6">Login</div>

        <form @submit.prevent="login" @keydown="form.onKeydown($event)" aria-label="Register" class="content">
            <div class="row">
                <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">E-mail Address</label>
                        <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" required>
                        <has-error :form="form" field="email"/>
                    </div>
                </div>
                <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Password</label>
                        <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password" required>
                        <has-error :form="form" field="password"/>
                    </div>
                </div>

                <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="remember mt-2">

                        <checkbox v-model="form.remember" name="remember" id="remember" :class="{ 'is-invalid': form.errors.has('remember') }">
                            Remember me
                        </checkbox>

                        <a class="forgot" href="/password/reset">
                            Forgot Your Password?
                        </a>
                    </div>
                    <v-button :loading="form.busy" class="btn-lg full-width">
                        Login
                    </v-button>

                    <div class="or"></div>

                    <a href="/social/facebook" class="btn btn-lg bg-facebook full-width btn-icon-left"><i class="fab fa-facebook-f" aria-hidden="true"></i>Login with Facebook</a>
                    <!--<a href="/social/google" class="btn btn-lg bg-google full-width btn-icon-left"><i class="fab fa-google-plus-g" aria-hidden="true"></i>Login with Gmail</a>-->

                    <p>Don’t you have an account? <a href="/register">Register Now!</a> it’s really simple and you can start enjoing all the benefits!</p>
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
                email: '',
                password: '',
                remember: true
            }),
            message: null
        }),
        methods: {
            async login () {
                const { data } = await this.form.post('/login');
                this.message = data.message;
                window.location.href="/universities";
            }
        }
    }
</script>
