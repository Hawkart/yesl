<template>
    <div>
        <ul class="comments-list">
            <comment v-for="comment in comments" :key="comment.id" :comment="comment" :user="user"/>
        </ul>

        <a href="#" class="more-comments" v-if="comments.length>1">View more comments <span>+</span></a>
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
    }
</script>