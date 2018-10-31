<template>
    <a class="nav-link" data-toggle="tab" href="#chat" role="tab">
        <div class="control-icon has-items">
            <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
            <div class="label-avatar bg-purple" v-if="count>0">{{count}}</div>
        </div>
    </a>
</template>

<script>
    export default {
        data: () => ({
            count: 0
        }),
        created() {
            this.getUnreadMessages();
        },
        methods: {
            getUnreadMessages() {

            }
        }
    }
</script>