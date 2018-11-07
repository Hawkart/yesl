<template>
    <li class="comment-item" :id="'comment-'+comment.id">
        <div class="post__author author vcard inline-items">

            <img :src="getImageLink(group.image)" :alt="group.title" v-if="group!=undefined && comment.user.id==group.owner_id">
            <img :src="getImageLink(comment.user.avatar)" :alt="comment.user.name" v-else>

            <div class="author-date">

                <template v-if="group!=undefined && comment.user.id==group.owner_id">
                    <a class="h6 post__author-name fn" :href="'/universities/'+group.slug" v-if="group.groupable_type='App\Models\University'">{{group.title}}</a>
                    <a class="h6 post__author-name fn" :href="'/games/'+group.slug" v-else-if="group.groupable_type='App\Models\Game'">{{group.title}}</a>
                </template>
                <template v-else>
                    <a class="h6 post__author-name fn" :href="'/users/'+comment.user.nickname">{{comment.user.name}} </a>
                </template>

                <template v-if="comment.reply_id>0">answer to <a href="#" @click.prevent="scrollToComment(comment.reply_id)">
                    <span v-if="group!=undefined && comment.user.id==group.owner_id">{{group.title}}</span>
                    <span v-else>{{comment.reply.user.name}}</span>
                </a></template>
                <div class="post__date">
                    <time class="published" datetime="moment.utc(comment.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                        {{moment.utc(comment.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                    </time>
                </div>
            </div>
        </div>

        <p><!--<template v-if="comment.reply_id>0"><a href="#" @click.prevent="scrollToComment(comment.reply_id)">{{comment.reply.user.name}}</a>, </template>--><span v-html="comment.comment"></span></p>

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
        <a href="#" class="reply" @click.prevent="makeReply(comment)">Reply</a>
    </li>
</template>

<script>
    export default {
        props: ['comment', 'user', 'group'],
        methods: {
            makeReply(comment) {
                this.$emit('setReply', comment);
            },
            scrollToComment(reply_id)
            {
                var topOfElement = document.querySelector('#comment-'+reply_id).offsetTop ;
                console.log(topOfElement);
                window.scroll({ top: topOfElement, behavior: "smooth" });
            }
        }
    }
</script>