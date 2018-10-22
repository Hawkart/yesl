<template>
  <div>
        <form @submit.prevent="csearch" @keydown="form.onKeydown($event)" class="w-search w-100" style="padding: 6px 25px; border-bottom: 1px solid #e6ecf5;">
            <div class="form-group with-button">
                <input class="form-control" v-model="form.q" @keyup="onkeyup" name="q" type="text" placeholder="Search..." :class="{ 'is-invalid': form.errors.has('q') }">
                <has-error :form="form" field="q"/>
                <v-button :loading="form.busy" type="primary" :large="false" style="width: 45px">
                    <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                </v-button>
            </div>
        </form>
        <ul class="notification-list chat-message">
            <template v-if="search!==null && search.users">
                <chat-search-users :users="search.users" @channelUserChanged="onChannelUserChanged"></chat-search-users>
                <chat-search-chats :channels="search.channels" @channelChanged="onChannelChanged"></chat-search-chats>
            </template>
            <template v-else-if="channels.length>0">
                <chat-channel :user="user" :channel="channel" :key="channel.id" :activeChannel="activeChannel" v-for="channel in channels" @channelChanged="onChannelChanged"/>
            </template>
            <template v-else>
                <li>
                    Sorry, no active chats.
                </li>
            </template>
        </ul>
    </div>
</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import ChatSearchUsers from "./ChatSearchUsers";
    import ChatChannel from "./ChatChannel";
    import ChatSearchChats from "./ChatSearchChats";

    export default {
        props: ['channels', 'activeChannel', 'user'],
        components: {
            VButton,
            ChatSearchUsers,
            ChatSearchChats,
            ChatChannel
        },
        data: () => ({
            form: new Form({
                q: ''
            }),
            message: '',
            search: []
        }),
        methods: {
            csearch()
            {
                this.form.post('/users/'+this.user.id+'/threads').then((response) => {
                    this.$set(this, 'search', response.data);
                });
            },
            onChannelUserChanged(channel) {
                this.$emit('channelUserChanged', channel);
                this.form.reset();
                this.search = [];
            },
            onChannelChanged(channel) {
                this.$emit('channelChanged', channel);
                this.form.reset();
                this.search = [];
            },
            onkeyup()
            {
                /*var timeout = null;
                var q = this.form.q;

                clearTimeout(timeout);

                // Make a new timeout set to go off in 800ms
                timeout = setTimeout(function () {
                    console.log('Input Value:', q);
                }, 1000);*/
            }
        }
    }
</script>