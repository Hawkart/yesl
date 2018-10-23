<template>
    <li :class="{ 'active': (activeChannel!==null && ((!channel.is_user && channel.id == activeChannel.id) || (channel.is_user && channel.participant.id == activeChannel.participant.id)) )}">
        <template v-if="channel.is_user==null">
            <div class="author-thumb">
                <img :src="getImageLink(participant.user.avatar)" :alt="participant.user.name" v-for="participant in channel.participants" :key="participant.id" v-if="channel.participants!==null && participant.user.id!=user.id">
            </div>
            <div class="notification-event">
                <a href="javascript:void(0)"
                   class="h6 notification-friend"
                   :class="{ 'active': (activeChannel!==null && channel.id == activeChannel.id) }"
                   @click="setChannel(channel)">
                    {{channel.participants[0].user.name}}
                </a>
                ({{channel.userUnreadMessagesCount}} unread)
                <span class="chat-message-item">{{ channel.latestMessage.body | truncate(100, '...')}}</span>
                <span class="notification-date">
                    <time class="published" datetime="moment.utc(channel.latestMessage.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                        {{moment.utc(channel.latestMessage.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                    </time>
                </span>
            </div>
        </template>
        <template v-else>
            <div class="author-thumb">
                <img :src="getImageLink(channel.participant.avatar)" :alt="channel.participant.name">
            </div>
            <div class="notification-event">
                <a href="javascript:void(0)"
                   class="h6 notification-friend"
                   :class="{ 'active': (activeChannel!==null && channel.participant.id == activeChannel.participant.id) }"
                   @click="setChannel(channel)">
                    {{channel.participant.name}}
                </a>
                <span class="chat-message-item">{{ channel.participant.description }}</span>
            </div>
        </template>

        <span class="notification-icon"><svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg></span>
        <div class="more">
            <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
        </div>
    </li>
</template>


<script>
    export default {
        props: ['channel', 'user', 'activeChannel'],
        methods: {
            setChannel(channel) {
                this.$emit('channelChanged', channel);
            }
        }
    }
</script>