<template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="message"/>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <img :src="getImageLink(profile.game.logo)" :alt="profile.game.title">
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating" :class="{ 'is-empty': form.nickname=='' }">
                            <label class="control-label">Nickname</label>
                            <input v-model="form.nickname" :class="{ 'is-invalid': form.errors.has('nickname') }" class="form-control" type="text" name="nickname">
                            <has-error :form="form" field="nickname"/>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating">
                            <label class="control-label">Link to game's account</label>
                            <input v-model="form.link" :class="{ 'is-invalid': form.errors.has('link') }" class="form-control" type="text" name="link" placeholder="https://website.com/path-to-account">
                            <has-error :form="form" field="link"/>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <v-button :loading="form.busy" type="primary" :large="true" additional="full-width">Save</v-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from 'vform'
    import VButton from "../Button";

    export default {
        components: {VButton},
        props: ['url', 'profile'],
        data: () => ({
            form: new Form({
                nickname: '',
                link: ''
            }),
            message: null
        }),
        created () {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                this.form[key] = this.profile[key];
            })
        },
        mounted() {
            this.getProfile();
        },
        methods: {
            update()
            {
                this.form.patch(this.url)
                    .then(({ data }) => {
                        this.message = data.message;
                    })
            }
        }
    }
</script>
