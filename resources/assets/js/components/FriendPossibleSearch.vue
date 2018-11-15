<template>

    <div>

    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Friend search ({{friends.length}})</h6>
            <a href="#" class="btn btn-primary btn-sm btn-right float-right" @click.prevent="show_advanced=!show_advanced">Advanced Search</a>
        </div>

        <form @submit.prevent="csearch" @keydown="form.onKeydown($event)" class="w-search w-100" style="padding: 6px 25px; border-bottom: 1px solid #e6ecf5;">
            <div v-if="show_advanced">
                There will be advanced filter
            </div>
            <div class="form-group with-button">
                <input class="form-control" v-model="form.q" name="q" type="text" placeholder="Start typing a friend's name..."
                       autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                       :class="{ 'is-invalid': form.errors.has('q') }">

                <has-error :form="form" field="q"/>
                <v-button :loading="form.busy" type="primary" :large="false" style="width: 45px">
                    <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                </v-button>
            </div>
        </form>

        <!--<ul class="notification-list friend-requests" v-if="friends!=null && friends.length>0">
            <li v-for="friend in friends" :key="friend.id">
                <div class="author-thumb">
                    <img :src="getImageLink(friend.avatar)" :alt="friend.name">
                </div>
                <div class="notification-event">
                    <a :href="'/users/'+friend.nickname" class="h6 notification-friend">{{friend.name}}</a>
                    <span class="chat-message-item">Mutual Friends: {{friend.mutualCount}}</span>
                </div>
                <span class="notification-icon mt-0">
                    <a href="#" class="accept-request">
                        <span class="icon-add">
                            <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                        </span>
                        Add as Friend
                    </a>
                </span>
            </li>
        </ul>-->

    </div>

    <div class="row" v-if="friends!=null && friends.length>0">

        <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6" v-for="(friend, index) in friends" :key="friend.id">
            <div class="ui-block">

                <div class="friend-item">
                    <div class="friend-header-thumb">
                        <img :src="friend.overlay ? getImageLink(friend.overlay) : '/img/top-header2.jpg'" :alt="friend.name">
                    </div>

                    <div class="friend-item-content">

                        <div class="friend-avatar mb-xxl-3">
                            <div class="author-thumb">
                                <img :src="getImageLink(friend.avatar)" :alt="friend.name">
                            </div>
                            <div class="author-content">
                                <a :href="'/users/'+friend.nickname" class="h6 notification-friend">{{friend.name}}</a>
                                <div class="country">Mutual Friends: {{friend.mutualCount}}</div>
                            </div>
                        </div>

                        <a href="#" class="accept-request btn-block" @click.prevent="addFriend(friend)" v-if="!checkIsRequested(friend.id)">
                            <span class="icon-add">
                                <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                            </span>
                            Add as Friend
                        </a>
                        <span class="alert alert-success" v-else>Request has been sent.</span>
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
            form: new Form({
                q: ''
            }),
            show_advanced: false,
            message: '',
            friends: [],
            page: 1,
            infiniteId: new Date(),
            requested: []
        }),
        methods: {
            infiniteHandler($state) {
                axios.get('/me/possibleFriends', {
                    params: {
                        page: this.page,
                        q: this.form.q,
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.friends = this.friends.concat(data.data);
                        $state.loaded();

                        if(this.friends.length >=data.total)
                        {
                            $state.complete();
                        }
                    } else {
                        $state.complete();
                    }
                });
            },
            csearch()
            {
                this.page = 1;
                this.friends = [];
                this.infiniteId += 1;
            },
            addFriend(friend)
            {
                axios.post('/me/addFriend', {id: friend.id}).then((response) => {

                    if(response.data.id>0)
                        this.requested.push(friend.id);
                });
            },
            checkIsRequested(fid)
            {
                return this.requested.includes(fid);
            }
        }
    }
</script>