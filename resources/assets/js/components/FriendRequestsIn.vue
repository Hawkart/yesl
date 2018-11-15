<template>

    <div>

        <div class="ui-block">
            <div class="ui-block-title">
                <h6 class="title">Incoming friend request ({{requests.length}})</h6>
            </div>
        </div>

        <div class="row" v-if="requests!=null && requests.length>0">
            <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6" v-for="(friendship, index) in requests" :key="friendship.id">
                <div class="ui-block">
                    <div class="friend-item">
                        <div class="friend-header-thumb">
                            <img :src="friendship.sender.overlay ? getImageLink(friendship.sender.overlay) : '/img/top-header2.jpg'" :alt="friendship.sender.name">
                        </div>

                        <div class="friend-item-content">
                            <div class="friend-avatar mb-xxl-3">
                                <div class="author-thumb">
                                    <img :src="getImageLink(friendship.sender.avatar)" :alt="friendship.sender.name">
                                </div>
                                <div class="author-content">
                                    <a :href="'/users/'+friendship.sender.nickname" class="h6 notification-friend">{{friendship.sender.name}}</a>
                                    <div class="country">Mutual friends: {{friendship.sender.mutualCount}}</div>
                                </div>
                            </div>

                            <span class="btn-block" v-if="friendship.status==2 && !accepted.includes(friendship.sender.id)">Status: <span class="text-danger">Denied</span></span>

                            <template v-if="!checkIsNotShowList(friendship.sender.id)">
                                <a href="#" class="accept-request btn-block" @click.prevent="acceptFriendship(friendship.sender)" >
                                    Accept
                                </a>
                                <a href="#" class="deny-request btn-block" @click.prevent="denyFriendship(friendship.sender)" v-if="friendship.status!=2">
                                    Deny
                                </a>
                            </template>
                            <span class="alert alert-success" v-else-if="denied.includes(friendship.sender.id)">Request has been denied.</span>
                            <span class="alert alert-success" v-else-if="accepted.includes(friendship.sender.id)">Request has been accepted.</span>
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
            notShowList: [],
            denied: [],
            accepted: []
        }),
        methods: {
            infiniteHandler($state) {
                axios.get('/me/friendRequestsIn', {
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
            acceptFriendship(sender)
            {
                axios.post('/me/acceptFriend', {id: sender.id}).then((response) => {
                    this.notShowList.push(sender.id);
                    this.accepted.push(sender.id);
                });
            },
            denyFriendship(sender)
            {
                axios.post('/me/denyFriend', {id: sender.id}).then((response) => {
                    this.notShowList.push(sender.id);
                    this.denied.push(sender.id);
                });
            },
            checkIsNotShowList(fid)
            {
                return this.notShowList.includes(fid);
            }
        }
    }
</script>