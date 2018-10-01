<template></template>
<script>
    import Form from 'vform'
    import VButton from "./Button";

    export default {
        components: {VButton},
        props: ['group', 'user'],
        data: () => ({
            form: new Form({
                nickname: '',
                link: ''
            }),
            message: null
        }),
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