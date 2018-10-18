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

        <p v-html="comment.comment"></p>

        <div class="links pa-0" v-if="comment.additional!=null && comment.additional.links!=null && comment.additional.links.length>0">
            <template v-for="link in comment.additional.links">
                <div class="post-video">
                    <div class="video-thumb mt-lg-4">
                        <img :src="link.img" :alt="link.title">
                    </div>

                    <div class="video-content">
                        <a v-bind:href="link.url" class="h4 title">{{link.title}}</a>
                        <p>{{link.description}}</p>
                        <a v-bind:href="link.url" class="link-site">{{link.url}}</a>
                    </div>
                </div>
            </template>
        </div>

        <like likeable_type="Comment" :likeable_id="comment.id" :likes="comment.likes" :user="user"/>
        <a href="#" class="reply">Reply</a>
    </li>
</template>

<script>
    export default {
        props: ['comment', 'user']
    }
</script>