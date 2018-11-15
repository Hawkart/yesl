<template>
    <div class="ui-block">
        <div class="ui-block-title">
            <h6 class="title">Friends ({{friends.length}})</h6>
            <a href="/friends/find" class="btn btn-primary btn-sm btn-right float-right">Find friends</a>
        </div>

        <form @submit.prevent="csearch" @keydown="form.onKeydown($event)" class="w-search w-100" style="padding: 6px 25px; border-bottom: 1px solid #e6ecf5;">
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

        <ul class="notification-list friend-requests" v-if="friends!=null && friends.length>0">
            <li v-for="friend in friends" :key="friend.id">
                <div class="author-thumb">
                    <img :src="getImageLink(friend.avatar)" :alt="friend.name">
                </div>
                <div class="notification-event">
                    <a :href="'/users/'+friend.nickname" class="h6 notification-friend">{{friend.name}}</a>
                </div>
                <span class="notification-icon mt-0">
                    <chat-dialog-button :participant='friend' :classes="'btn-sm btn-primary'">Message</chat-dialog-button>
                    <a href="#" class="btn btn-sm btn-smoke btn-light-bg" @click.prevent="removeFriend(friend)">Remove from friends</a>
                </span>
            </li>
        </ul>

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
            infiniteId: new Date()
        }),
        methods: {
            infiniteHandler($state) {
                axios.get('/me/friends', {
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
            removeFriend(friend)
            {
                axios.post('/me/unfriend', {id: friend.id}).then((response) => {
                    var id = friend.id;

                    this.friends = this.friends.filter(function(friend) {
                        if(friend.id!=id)
                            return true;

                        return false;
                    });
                });
            }
        }
    }
</script>