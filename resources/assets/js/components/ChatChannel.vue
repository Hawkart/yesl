<template>
    <li :class="{ 'active': (activeChannel!==null && ((!channel.is_user && channel.id == activeChannel.id) || (channel.is_user && channel.participant.id == activeChannel.participant.id)) )}">
        <template v-if="channel.is_user==null">
            <div class="author-thumb">
                <img :src="getImageLink(participant.user.avatar)" :alt="participant.user.name" v-for="participant in channel.participants" :key="participant.id" v-if="channel.participants!==null && participant.user.id!=user.id">
            </div>
            <div class="notification-event">
                <a href="javascript:void(0)"
                   class="h6 notification-friend"
                   @click="setChannel(channel)">
                    <template v-if="channel.participants[0].user.id!=user.id">{{channel.participants[0].user.name}}</template>
                    <template v-else>{{channel.participants[1].user.name}}</template>
                </a>
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
                   @click="setChannel(channel)">
                    {{channel.participant.name}}
                </a>
                <span class="chat-message-item">{{ channel.participant.description }}</span>
            </div>
        </template>

        <span class="notification-icon">
            <span class="items-round-little bg-breez inline-block mr-xxl-2" v-if="channel.userUnreadMessagesCount>0">{{channel.userUnreadMessagesCount}}</span>
            <a href="#" @click.prevent="setChannel(channel)" class="btn btn-sm btn-primary mb-0">
                <img src="/svg-icons/sprites/Message_top.svg" style="width: 20px; height: 20px;" class="mr-xxl-2"><template v-if="activeChannel===null"> Message</template></a>
        </span>
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