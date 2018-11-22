<template>
    <div>
        <alert-success :form="form" :message="message"/>
        <form @submit.prevent="save" @keydown="form.onKeydown($event)">
            <template v-if="is_subscribed">
                <v-button :loading="form.busy" type="primary" :large="false" additional="btn-xs full-width mt-lg-3 mb-0">Unfollow</v-button>
            </template>
            <template v-else>
                <v-button :loading="form.busy" type="primary" :large="false" additional="btn-xs full-width mt-lg-3 mb-0">Follow</v-button>
            </template>
        </form>
    </div>

</template>
<script>
    import Form from 'vform'
    import VButton from "./Button";

    export default {
        components: {VButton},
        props: ['group_id'],
        data: () => ({
            form: new Form(),
            message: null,
            is_subscribed: false
        }),
        mounted() {
            this.checkUserInGroup();
        },
        methods: {
            checkUserInGroup()
            {
                axios.post('/groups/'+this.group_id+'/checkin')
                    .then(({ data }) => {
                        if(data.user_id!=null)
                        {
                            this.is_subscribed = true;
                        }
                    });
            },
            save()
            {
                this.form.post('/groups/'+this.group_id+'/users')
                    .then(({ data }) => {
                        this.message = data.message;
                        window.location.reload();
                    })
            }
        }
    }
</script>