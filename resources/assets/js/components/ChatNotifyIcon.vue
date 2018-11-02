<template>
    <div>
        <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
        <div class="label-avatar bg-purple" v-if="count>0">{{count}}</div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data: () => ({
            count: 0
        }),
        created() {
            this.getUnreadMessages();

            window.Echo.private("channel_chats_"+this.user.id.toString())
                .listen('UpdateCount', data => {
                    this.count = data.data;
                });
        },
        methods: {
            getUnreadMessages() {

            }
        }
    }
</script>