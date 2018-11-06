<template>
    <div>
        <img src="/svg-icons/sprites/Message_top.svg" style="width: 28px; height: 28px;">
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