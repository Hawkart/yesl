<template>

    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Games Profiles</h6>

            <div class="align-right">
                <a href="#" data-toggle="modal" data-target="#create-photo-album" class="btn btn-primary btn-md-2">Create profile  +<div class="ripple-container"></div></a>
            </div>
        </div>

        <ul class="notification-list friend-requests" v-if="profiles!==null && profiles.length>0">
            <li v-for="profile in profiles">
                <div style="width: 50px;">
                    <img :src="getImageLink(profile.game.logo)" :alt="profile.game.title" :title="profile.game.title">
                </div>
                <div class="notification-event">
                    <a href="#" class="h6 notification-friend">{{profile.nickname}}</a>
                </div>
                <span class="notification-icon">
                    <a href="#" class="accept-request">
                        <span class="icon-add without-text">
                            <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                        </span>
                    </a>

                    <a href="#" class="accept-request request-del">
                        <span class="icon-minus">
                            <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                        </span>
                    </a>
                </span>

                <div class="more">
                    <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import Form from 'vform'
    import VButton from "../Button";

    export default {
        components: {VButton},
        props: ['profiles'],
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
