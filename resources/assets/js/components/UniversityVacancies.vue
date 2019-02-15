<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h2 class="title">Vacancies</h2>

            <div class="align-right" v-if="user.id==group.owner_id">
                <a href="#" @click="openModalForm" data-toggle="modal" data-target="#create-university-vacancy" class="btn btn-primary btn-md-2">Add vacancy  +</a>
            </div>
        </div>

        <div class="ui-block-content">
            <div class="row" v-if="message">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div role="alert" class="alert alert-success alert-dismissible">
                        <button type="button" aria-label="Close" class="close" @click.prevent="close"><span aria-hidden="true">×</span></button>
                        <div>{{message}}</div>
                    </div>
                </div>
            </div>

            <div v-if="vacancies">
                <div class="row mb-25" v-for="(vacancy, gkey) in vacancies" :key="vacancy.game.id">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <h5 class="title">{{vacancy.game.title}}:</h5>
                        <ul class="notification-list friend-requests" >
                            <li v-for="(v, vkey) in vacancy.data" v-if="v!==undefined" :key="v.id">
                                <div class="d-block">
                                    <strong>Quantity for team:</strong> {{v.quantity}}<br/>
                                    <strong>Description:</strong> {{v.description}}
                                </div>
                                <div class="d-block mt-2">
                                    <chat-dialog-button :participant='group.owner' :classes="'pa-0 mb-0'">
                                        <button type="submit" class="btn btn-sm btn-primary mt-0">Apply</button>
                                    </chat-dialog-button>

                                    <a href="#" @click.prevent="del(v.id, gkey, vkey)" class="btn btn-grey-lighter btn-sm"  v-if="user.id==group.owner_id">Delete</a>
                                </div>
                            </li>
                        </ul>
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
            del(id, gkey, vkey){

                axios.delete('/vacancies/'+id)
                    .then(({ data }) => {
                        this.message = data.message;
                        this.vacancies[gkey].data[vkey] = undefined;
                    })
            },
            close()
            {
                this.message = '';
            }
        }
    }
</script>
