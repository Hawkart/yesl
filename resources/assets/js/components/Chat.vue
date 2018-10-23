<template>

    <div class="row">
        <div class="col col-md-12 col-sm-12" v-bind:class="isActiveChannel">
            <perfect-scrollbar id="chatsDisplay">
                <chat-channel-list :channels="channels"
                               :active-channel="activeChannel"
                               :user="user"
                               @channelChanged="onChannelChanged"
                               @channelUserChanged="onChannelUserChanged"></chat-channel-list>

            </perfect-scrollbar>
        </div>

        <div class="col col-xl-7 col-lg-6 col-md-12 col-sm-12 padding-l-0" v-if="activeChannel!=null">
            <div class="chat-field">
                <div class="ui-block-title">
                    <h6 class="title" v-if="!activeChannel.is_user">{{activeChannel.subject}}</h6>
                    <h6 class="title" v-else>{{activeChannel.participant.name}}</h6>
                    <a href="#" class="more">
                        <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
                    </a>
                </div>
                <chat-messages :messages="messages" :isTyping="isTyping":user="user"></chat-messages>
                <chat-new-message :active-channel="activeChannel" :user="user"
                                  @messageAdded="onMessageAdded"></chat-new-message>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import ChatMessages from "./ChatMessages";
    import ChatNewMessage from "./ChatNewMessage";
    import ChatChannelList from "./ChatChannelList";
    import ChatParticipants from "./ChatParticipants";
    import { PerfectScrollbar } from 'vue2-perfect-scrollbar'

    export default {
        props: ['user'],
        components: {
            ChatParticipants,
            ChatChannelList,
            ChatMessages,
            ChatNewMessage,
            PerfectScrollbar
        },
        computed: {
            isActiveChannel: function() {
                return this.activeChannel ? 'col-xl-5 col-lg-6 padding-r-0' : 'col-xl-12 col-lg-12';
            }
        },
        data() {
            return {
                channels: [],
                participants: [],
                socket: null,
                messages: null,
                activeChannel: null,
                isTyping: false,
                typingTimer: false
            };
        },
        created() {
            this.getThreads();
            this.fetchMessages();
            //this.fetchParticipants();

            for (let channel of this.channels)
            {
                window.Echo.private("channel_"+channel.id.toString())
                    .listen('MessageSent', data => {
                        if(this.activeChannel.id==channel.id)
                        {
                            this.messages.push(data.data);
                            this.isTyping = false;
                        }
                    })
                    .listenForWhisper('typing', (e) => {
                        this.isTyping = e;

                        if(this.typingTimer) clearTimeout(this.typingTimer);

                        this.typingTimer = setTimeout(() =>{
                            this.isTyping = false;
                        }, 2000)
                    });
            }
        },
        methods: {
            getThreads: function()
            {
                axios.get('/users/'+this.user.id+'/threads').then((response) => {
                    this.$set(this, 'channels', response.data);
                });
            },
            fetchMessages()
            {
                if(this.activeChannel!==null)
                {
                    axios.get('/channels/'+this.activeChannel.id+'/messages')
                        .then(({ data }) => {
                            this.messages = data;
                        });
                }
            },
            fetchParticipants()
            {
                if(this.activeChannel!==null)
                {
                    axios.get('/channels/'+this.activeChannel.id+'/participants')
                        .then(({ data }) => {
                            this.participants = data;
                        });
                }
            },
            onChannelChanged(channel) {
                this.activeChannel = channel;

                this.fetchMessages();
                this.fetchParticipants();
            },
            onChannelUserChanged(participant)
            {
                //check if channel exists in list
                var exists = false;
                this.channels.forEach(function(channel, i) {
                    if(channel.is_user && participant.id==channel.participant.id)
                    {
                        this.activeChannel = channel;
                        exists = true;
                    }
                });

                if(!exists)
                {
                    this.activeChannel = {
                        "id" : 0,
                        "is_user" : true,
                        "participant" : participant
                    };
                    this.channels.unshift(this.activeChannel);
                }
            },
            onMessageAdded(data) {

                //check if channel was created
                this.channels.forEach(function(channel, i) {
                    if(channel.is_user && data.participants[0]==channel.participant.id)
                    {
                        this.channels[i] = data.thread;
                        this.activeChannel = data.thread;
                    }
                });

                this.messages.push(data.message);
            }
        },
    }
</script>
<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css"/>