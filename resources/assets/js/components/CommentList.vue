<template>
    <div>
        <ul class="comments-list" v-if="comments.length>0">
            <comment v-for="(comment, index) in comments" :key="comment.id" :comment="comment" :group="group" :user="user" v-if="(index<1 && !show_comments) || show_comments" @setReply="onSetReply"/>
        </ul>

        <a href="#" class="more-comments" @click.prevent="show_comments=!show_comments" v-if="comments.length>1 && !show_comments">View more comments({{comments.length-1}}) <span>+</span></a>
    </div>
</template>

<script>
    export default {
        props: ['comments', 'user', 'post_id', 'group'],
        created(){
            Event.listen("CommentNew"+this.post_id, (comment) => {
                this.comments.unshift(comment);
            })
        },
        data: () => ({
            per_page: 10,
            show_comments: false
        }),
        methods: {
            onSetReply(comment) {
                this.$emit('setReply', comment);
            }
        }
    }
</script>