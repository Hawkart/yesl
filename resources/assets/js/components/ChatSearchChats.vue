<template>
    <ul v-if="channels!==null && channels.length>0">
        <li><span class="h6">Chats ({{channels.length}})</span></li>
        <li v-for="channel in channels">
            <div class="author-thumb">
                <img :src="getImageLink(participant.user.avatar)" :alt="participant.user.name" v-for="participant in channel.participants" :key="participant.id" v-if="channel.participants!==null && participant.user.id!=user.id">
            </div>
            <div class="notification-event">
                <a href="javascript:void(0)"
                   class="h6 notification-friend"
                   @click="setChannel(channel)">
                    {{channel.participantsString}}
                </a>
                ({{channel.userUnreadMessagesCount}} unread)
                <span class="chat-message-item">{{ channel.latestMessage.body }}</span>
                <span class="notification-date">
                    <time class="published" datetime="moment.utc(channel.latestMessage.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                        {{moment.utc(channel.latestMessage.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                    </time>
                </span>
            </div>
            <span class="notification-icon"><svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg></span>
            <div class="more">
                <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
            </div>
        </li>
    </ul>
</template>


<script>
    export default {
        props: ['channels'],
        methods: {
            setChannel(channel) {
                this.$emit('channelChanged', channel);
            }
        }
    }
</script>