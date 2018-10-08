<template>
    <div class="ui-block">

        <article class="hentry post video">

            <div class="post__author author vcard inline-items">
                <img :src="getImageLink(post.user.avatar)" :alt="post.user.name">

                <div class="author-date">
                    <a class="h6 post__author-name fn" href="#">{{post.user.name}}</a><!-- shared a <a href="#">link</a>-->
                    <div class="post__date">
                        <time class="published" datetime="moment.utc(post.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                            {{moment.utc(post.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                        </time>
                    </div>
                </div>

                <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
                    <ul class="more-dropdown">
                        <li>
                            <a href="#">Edit Post</a>
                        </li>
                        <li>
                            <a href="#">Delete Post</a>
                        </li>
                        <li>
                            <a href="#">Turn Off Notifications</a>
                        </li>
                        <li>
                            <a href="#">Select as Featured</a>
                        </li>
                    </ul>
                </div>

            </div>

            <p>{{post.text}}</p>

            <!--<div class="post-video">
                <div class="video-thumb">
                    <img src="img/video-youtube1.jpg" alt="photo">
                    <a href="https://youtube.com/watch?v=excVFQ2TWig" class="play-video">
                        <svg class="olymp-play-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-play-icon"></use></svg>
                    </a>
                </div>

                <div class="video-content">
                    <a href="#" class="h4 title">Iron Maid - ChillGroves</a>
                    <p>Lorem ipsum dolor sit amet, consectetur ipisicing elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua...
                    </p>
                    <a href="#" class="link-site">YOUTUBE.COM</a>
                </div>
            </div>-->

            <div class="post-block-photo js-zoom-gallery" v-if="post.media!=null && post.media.length>0">
                <a :href="'/storage/'+media.id+'/'+media.file_name" class="col col-3-width" v-for="media in post.media">
                    <img :src="'/storage/'+media.id+'/'+media.file_name" :alt="media.file">
                </a>
            </div>

            <div class="post-additional-info inline-items">

                <like likeable_type="Post" :likeable_id="post.id" :likes="post.likes" :user="user"/>

                <div class="comments-shared">
                    <a href="#" class="post-add-icon inline-items" v-on:click.prevent="show_comments=!show_comments">
                        <svg class="olymp-speech-balloon-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-speech-balloon-icon"></use></svg>
                        <span>{{ post.comments.length }}</span>
                    </a>

                    <a href="#" class="post-add-icon inline-items">
                        <svg class="olymp-share-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-share-icon"></use></svg>
                        <span>0</span>
                    </a>
                </div>
            </div>

            <!--<div class="control-block-button post-control-button">
                <a href="#" class="btn btn-control">
                    <svg class="olymp-like-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-like-post-icon"></use></svg>
                </a>

                <a href="#" class="btn btn-control">
                    <svg class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                </a>

                <a href="#" class="btn btn-control">
                    <svg class="olymp-share-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-share-icon"></use></svg>
                </a>
            </div>-->

        </article>

        <comment-list :comments="post.comments" :post_id="post.id" :user="user" v-if="show_comments"></comment-list>
        <comment-form :post_id="post.id" :user="user" reply_id="0" v-if="show_comments"></comment-form>
        <!-- v-on:commented="updateComment"-->
    </div>
</template>


<script>
    export default {
        props: ['post', 'user'],
        data: () => ({
            posts: [],
            per_page: 10,
            show_comments: false
        }),
        created(){
            if(this.post.comments.length>0)
                this.show_comments = true;
        },
        methods: {

        }
    }
</script>