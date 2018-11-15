<template>

    <div class="ui-block" v-if="friends!=null && friends.length>0">
        <div class="ui-block-title">
            <h6 class="title">People you may know</h6>
        </div>

        <ul class="widget w-friend-pages-added notification-list friend-requests">
            <li class="inline-items" v-for="friend in friends" :key="friend.id">
                <div class="author-thumb">
                    <img :src="getImageLink(friend.avatar)" :alt="friend.name">
                </div>
                <div class="notification-event">
                    <a :href="'/users/'+friend.nickname" class="h6 notification-friend">{{friend.name}}</a>
                    <span class="chat-message-item">Mutual Friends: {{friend.mutualCount}}</span>
                </div>
                <span class="notification-icon mt-0" v-if="!checkIsRequested(friend.id)">
                    <a href="#" class="accept-request" @click.prevent="addFriend(friend)" >
                        <span class="icon-add without-text">
                            <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                        </span>
                    </a>
                </span>
                <span class="notification-icon mt-2" v-else>
                    <span ><i class="fas fa-check"></i></span>
                </span>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: [],
        data: () => ({
            friends: [],
            page: 1,
            requested: []
        }),
        mounted() {
            this.getFriends();
        },
        methods: {
            getFriends(){
                axios.get('/me/possibleFriends', {
                    params: {
                        page: 1
                    },
                }).then(({ data }) => {
                    this.friends = data.data;
                });
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