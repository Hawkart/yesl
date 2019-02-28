<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h2 class="title">Players Needed</h2>

            <div class="align-right" v-if="user.id==group.owner_id">
                <a href="#" @click="openModalForm" data-toggle="modal" data-target="#create-university-vacancy" class="btn btn-primary btn-md-2">Add +</a>
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

            <div v-if="vacancies">

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12"  v-for="vacancy in vacancies" :key="vacancy.id">
                        <div class="ui-block">
                            <article class="hentry blog-post" data-mh="choose-item">
                                <div class="post-thumb">
                                    <img :src="getImageLink(vacancy.game.logo)" :alt="vacancy.game.title">
                                </div>
                                <div class="post-content pb-0">
                                    <chat-dialog-button :participant='group.owner' :classes="'pa-0 mb-0 full-width'">
                                        <button type="submit" class="btn btn-sm btn-primary full-width mt-0">Apply</button>
                                    </chat-dialog-button>

                                    <a href="#" @click.prevent="del(vacancy.id)" class="btn btn-grey-lighter btn-sm full-width"  v-if="user.id==group.owner_id">Delete</a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-1 text-center" v-else>
                University hasn't vacancies yet!
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['vacancies', 'university', 'group', 'user'],
        data: () => ({
            message: null
        }),
        created(){
            Event.listen('UniversityVacancyNew', (vacancies) => {
                this.vacancies = vacancies;
            });
        },
        methods: {
            openModalForm()
            {
                Event.fire("UniversityVacancyAddModalOpen", {
                    'vacancies': this.vacancies,
                    'university': this.university
                });
            },
            del(id){

                axios.delete('/vacancies/'+id)
                    .then(({ data }) => {

                        this.message = data.message;

                        var vacancies = this.vacancies.filter(function(vacancy) {
                            if(vacancy.id!=id)
                                return true;

                            return false;
                        });

                        this.vacancies = vacancies;
                    })
            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
