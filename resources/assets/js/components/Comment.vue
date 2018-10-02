<template>
    <li class="comment-item">
        <div class="post__author author vcard inline-items">
            <img :src="getImageLink(comment.user.avatar)" :alt="comment.user.name">
            <div class="author-date">
                <a class="h6 post__author-name fn" :href="'/users/'+comment.user.nickname">{{comment.user.name}}</a>
                <div class="post__date">
                    <time class="published" datetime="moment.utc(comment.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                        {{moment.utc(comment.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                    </time>
                </div>
            </div>
        </div>
        <p>{{comment.comment}}</p>
        <like likeable_type="Comment" :likeable_id="comment.id" :likes="comment.likes" :user="user"/>
        <a href="#" class="reply">Reply</a>
    </li>
</template>

<script>
    export default {
        props: ['comment', 'user']
    }
</script>