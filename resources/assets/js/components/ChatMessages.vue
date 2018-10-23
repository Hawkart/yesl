<template>
    <div>
        <perfect-scrollbar ref='messageDisplay' id="messageDisplay">
            <ul class="notification-list chat-message chat-message-field">
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
        </perfect-scrollbar>
    </div>
</template>

<script>
    import { PerfectScrollbar } from 'vue2-perfect-scrollbar'
    export default {
        props: ['messages', 'isTyping', 'user'],
        components: {
            PerfectScrollbar
        },
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
                    //var messageDisplay = this.$refs.messageDisplay;
                    var messageDisplay = this.$el.querySelector("#messageDisplay");
                    messageDisplay.scrollTop = messageDisplay.scrollHeight;
                });
            }
        },
    }
</script>
<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css"/>