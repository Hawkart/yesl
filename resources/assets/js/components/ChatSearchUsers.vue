<template>
    <ul v-if="users!==null && users.length>0">
        <li><span class="h6">Users ({{users.length}})</span></li>
        <li v-for="user in users">
            <div class="author-thumb">
                <img :src="getImageLink(user.avatar)" :alt="user.name">
            </div>
            <div class="notification-event">
                <a href="javascript:void(0)"
                   class="h6 notification-friend"
                   @click="setChannelByUser(user)">
                    {{user.name}}
                </a>
                <span class="chat-message-item">{{ user.description }}</span>
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
        props: ['users'],
        methods: {
            setChannelByUser(channel) {
                this.$emit('channelUserChanged', channel);
            }
        }
    }
</script>