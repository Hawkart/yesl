<template>

    <ul class="notification-list chat-message chat-message-field" ref="message-window">
        <li :class="message.user.id==user.id ? 'self' : 'friend'" v-for="message in messages"
            :key="message.id"
        >
            <div class="author-thumb">
                <img :src="getImageLink(message.user.avatar)" :title="message.user.nickname" :alt="message.user.nickname">
            </div>
            <div class="notification-event w-100">
                <a :href="'/users/'+message.user.nickname" class="h6 notification-friend">{{message.user.name}}</a>
                <span class="notification-date">
                    <time class="entry-date updated" datetime="moment.utc(message.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                        {{moment.utc(message.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                    </time>
                </span>
                <span class="chat-message-item w-100">
                    {{ message.body }}
                </span>
            </div>
        </li>
        <li v-if="isTyping && isTyping.user.id!=user.id" class="friend">
            <div class="author-thumb">
                <img :src="getImageLink(isTyping.user.avatar)" :title="isTyping.user.nickname" :alt="isTyping.user.nickname">
            </div>
            <div class="notification-event w-100">
                <a :href="'/users/'+isTyping.user.nickname" class="h6 notification-friend">{{message.user.name}}</a>
                <span class="notification-date">
                    &nbsp;
                </span>
                <span class="chat-message-item w-100">
                    Is typing...
                </span>
            </div>
        </li>
    </ul>


    <!--<ul class="chatapp-chat-nicescroll-bar pt-10" ref="message-window">
        <li :class="message.user.id==user.id ? 'self' : 'friend'" v-for="message in messages"
            :key="message.id"
        >
            <div v-if="message.user.id==user.id" class="self-msg-wrap">
                <div class="msg block pull-right"> {{ message.body }}
                    <div class="msg-per-detail text-right">
                        <span class="msg-time txt-grey">{{ message.created_at }}</span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div v-else class="friend-msg-wrap">
                <img class="rounded-circle profile-photo w-20 block pull-left" :src="getImageLink(message.user.avatar)" :title="message.user.nickname" :alt="message.user.nickname"/>
                <div class="msg pull-left">
                    {{ message.body }}
                    <div class="msg-per-detail  text-right">
                        <span class="msg-time txt-grey">{{ message.created_at }}</span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </li>
        <li v-if="isTyping && isTyping.user.id!=user.id" class="friend">
            <div class="friend-msg-wrap">
                <img class="rounded-circle profile-photo w-20 block pull-left" :src="getImageLink(isTyping.user.avatar)" :title="isTyping.user.nickname" :alt="isTyping.user.nickname"/>
                <div class="msg pull-left">
                    <div class="msg-per-detail text-right">
                        <span class="msg-time txt-grey">набирает сообщение...</span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </li>
    </ul>-->
</template>

<script>
    export default {
        props: ['messages', 'isTyping', 'user'],
        mounted() {
            this.scrollToBottom();
        },
        watch: {
            messages() {
                this.scrollToBottom();
            }
        },

        methods: {
            scrollToBottom() {
                this.$nextTick(() => {
                    this.$refs['message-window'].scrollTop = this.$refs['message-window'].scrollHeight;
                });
            }
        },
    }
</script>