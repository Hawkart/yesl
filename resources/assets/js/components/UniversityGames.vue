<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h2 class="title">Teams</h2>

            <div class="align-right" v-if="user.id==group.owner_id">
                <a href="#" @click="openModalForm" data-toggle="modal" data-target="#create-university-team" class="btn btn-primary btn-md-2">Add team  +</a>
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

            <div class="row" v-if="teams!==null && teams.length>0">
                <div class="col-lg-4 col-md-4 col-sm-6" v-for="team in teams">
                    <img :src="getImageLink(team.logo)" :alt="team.title" :title="team.title">
                    <a href="#" @click.prevent="del(team.id)" class="btn btn-grey-lighter btn-sm full-width"  v-if="user.id==group.owner_id">Delete</a>
                </div>
            </div>

            <div class="mt-1 text-center" v-else>
                University hasn't teams yet!
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['teams', 'university', 'group', 'user'],
        data: () => ({
            message: null
        }),
        created(){
            Event.listen('UniversityGameNew', (teams) => {
                this.teams = teams;
            });
        },
        methods: {
            openModalForm()
            {
                Event.fire("UniversityGameAddModalOpen", {
                    'teams': this.teams,
                    'university': this.university
                });
            },
            del(id){
                axios.delete('/universities/'+this.university.id+'/games/'+id)
                    .then(({ data }) => {
                        this.message = data.message;

                        var teams = this.teams.filter(function(team) {
                            if(team.id!=id)
                                return true;

                            return false;
                        });

                        this.teams = teams;
                    })
            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
