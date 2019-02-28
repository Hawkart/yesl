<template>

    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Games Profiles</h6>

            <div class="align-right">
                <a href="#" data-toggle="modal" data-target="#create-photo-album" class="btn btn-primary btn-md-2">Create profile  +</a>
            </div>
        </div>

        <div class="row" v-if="message">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div role="alert" class="alert alert-success alert-dismissible">
                    <button type="button" aria-label="Close" class="close" @click.prevent="close"><span aria-hidden="true">×</span></button>
                    <div>{{message}}</div>
                </div>
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
                    <a :href="'/settings/profiles/'+profile.id" class="btn btn-blue btn-sm">Edit</a>
                    <a @click.prevent="del(profile.id)" class="btn btn-grey-lighter btn-sm">Delete</a>
                </span>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['profiles'],
        data: () => ({
            message: null
        }),
        created(){
            Event.listen('ProfileNew', (profiles) => {
                this.profiles = profiles;
            })
        },
        methods: {
            update()
            {
                this.form.patch(this.url)
                    .then(({ data }) => {
                        this.message = data.message;
                        this.form.reset()
                    })
            },
            del(id){
                axios.delete('/profiles/'+id)
                    .then(({ data }) => {
                        this.message = data.message;

                        var profiles = this.profiles.filter(function(profile) {
                            if(profile.id!=id)
                                return true;

                            return false;
                        });

                        this.profiles = profiles;
                    })
            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
