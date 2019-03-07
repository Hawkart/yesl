<template>

    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Gamer Profiles</h6>

            <div class="align-right">
                <a href="/settings/profiles/add" class="btn btn-primary btn-md-2">Create profile  +</a>
            </div>
        </div>

        <div class="ui-block-content">
            <div class="row" v-if="message">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div role="alert" class="alert alert-success alert-dismissible">
                        <button type="button" aria-label="Close" class="close" @click.prevent="close"><span aria-hidden="true">×</span></button>
                        <div>{{message}}</div>
                    </div>
                </div>
            </div>

            <div v-if="profiles!==null && profiles.length>0">

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12"  v-for="profile in profiles" :key="profile.id">
                        <div class="ui-block">
                            <article class="hentry blog-post" data-mh="choose-item">
                                <div class="post-thumb">
                                    <img :src="getImageLink(profile.game.logo)" :alt="profile.game.title">
                                </div>
                                <div class="post-content pb-0">
                                    <a :href="'/settings/profiles/'+profile.id+'/edit'" class="btn btn-blue btn-sm full-width">Edit</a>
                                    <a href="#" @click.prevent="del(profile.id)" class="btn btn-grey-lighter btn-sm full-width">Delete</a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-1 text-center" v-else>
                No one gamer profile hasn't created yet!
            </div>
        </div>
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
            edit(id)
            {

            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
