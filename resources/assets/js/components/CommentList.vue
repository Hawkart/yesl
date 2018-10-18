<template>
    <div>
        <ul class="comments-list" v-if="comments.length>0">
            <comment v-for="(comment, index) in comments" :key="comment.id" :comment="comment" :user="user" v-if="(index<1 && !show_comments) || show_comments"/>
        </ul>

        <a href="#" class="more-comments" v-on:click.prevent="show_comments=!show_comments" v-if="comments.length>1 && !show_comments">View more comments({{comments.length-1}}) <span>+</span></a>
    </div>
</template>

<script>
    export default {
        props: ['comments', 'user', 'post_id'],
        created(){
            Event.listen("CommentNew"+this.post_id, (comment) => {
                this.comments.unshift(comment);
            })
        },
        data: () => ({
            per_page: 10,
            show_comments: false
        })
    }
</script>