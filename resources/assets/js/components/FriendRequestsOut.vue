<template>

    <div>

        <div class="ui-block">
            <div class="ui-block-title">
                <h6 class="title">Outgoing friend request ({{requests.length}})</h6>
            </div>
        </div>

        <div class="row" v-if="requests!=null && requests.length>0">

            <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6" v-for="(friendship, index) in requests" :key="friendship.id">
                <div class="ui-block">

                    <div class="friend-item">
                        <div class="friend-header-thumb">
                            <img :src="friendship.recipient.overlay ? getImageLink(friendship.recipient.overlay) : '/img/top-header2.jpg'" :alt="friendship.recipient.name">
                        </div>

                        <div class="friend-item-content">

                            <div class="friend-avatar mb-xxl-3">
                                <div class="author-thumb">
                                    <img :src="getImageLink(friendship.recipient.avatar)" :alt="friendship.recipient.name">
                                </div>
                                <div class="author-content">
                                    <a :href="'/users/'+friendship.recipient.nickname" class="h6 notification-friend">{{friendship.recipient.name}}</a>
                                    <div class="country">Mutual friends: {{friendship.recipient.mutualCount}}</div>
                                </div>
                            </div>

                            <a href="#" class="accept-request btn-block" @click.prevent="deleteFriendship(friendship)" v-if="!checkIsDeleted(friendship.id)">
                                Delete request
                            </a>
                            <span class="alert alert-success" v-else>Request has been deleted.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <infinite-loading :identifier="infiniteId" @infinite="infiniteHandler"></infinite-loading>

    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading'
    import axios from 'axios'
    import Form from 'vform'
    import VButton from "./Button"

    export default {
        components: {InfiniteLoading, Form, VButton},
        props: [],
        data: () => ({
            message: '',
            requests: [],
            page: 1,
            infiniteId: new Date(),
            deleted: []
        }),
        methods: {
            infiniteHandler($state) {
                axios.get('/me/friendRequestsOut', {
                    params: {
                        page: this.page
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.requests = this.requests.concat(data.data);
                        $state.loaded();

                        if(this.requests.length >=data.total)
                        {
                            $state.complete();
                        }
                    } else {
                        $state.complete();
                    }
                });
            },
            deleteFriendship(friendship)
            {
                axios.delete('/friendships/'+friendship.id).then((response) => {
                    this.deleted.push(friendship.id);
                });
            },
            checkIsDeleted(fid)
            {
                return this.deleted.includes(fid);
            }
        }
    }
</script>