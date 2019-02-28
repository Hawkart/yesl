<template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="message"/>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating" :class="{ 'is-empty': form.password=='' }">
                    <label class="control-label">Your New Password</label>
                    <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                    <has-error :form="form" field="password"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating" :class="{ 'is-empty': form.password_confirmation=='' }">
                    <label class="control-label">Confirm New Password</label>
                    <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                    <has-error :form="form" field="password_confirmation"/>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <v-button :loading="form.busy" type="primary" :large="true" additional="full-width">Change Password Now!</v-button>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from 'vform'
    import VButton from "../Button";

    export default {
        components: {VButton},
        props: ['url'],
        data: () => ({
            form: new Form({
                password: '',
                password_confirmation: ''
            }),
            message: null
        }),
        methods: {
            update()
            {
                this.form.patch(this.url)
                    .then(({ data }) => {
                        this.message = data.message;
                        this.form.reset()
                    })
            }
        }
    }
</script>
