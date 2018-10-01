<template>
    <div id="newsfeed-items-grid">
        <div class="ui-block" v-for="post in posts" v-if="posts!=null && posts.length>0">

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

                <div class="post-additional-info inline-items">

                    <a href="#" class="post-add-icon inline-items">
                        <svg class="olymp-heart-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-heart-icon"></use></svg>
                        <span>{{ post.likes.length }}</span>
                    </a>

                    <ul class="friends-harmonic">
                        <li v-for="like in post.likes" v-if="post.likes!=null && post.likes.length>0">
                            <a href="#">
                                <img :src="getImageLink(like.user.avatar)" :alt="like.user.name" width="36">
                            </a>
                        </li>
                    </ul>

                    <!--<div class="names-people-likes">
                        <a href="#">Jenny</a>, <a href="#">Robert</a> and
                        <br>18 more liked this
                    </div>-->

                    <div class="comments-shared">
                        <a href="#" class="post-add-icon inline-items">
                            <svg class="olymp-speech-balloon-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-speech-balloon-icon"></use></svg>
                            <span>0</span>
                        </a>

                        <a href="#" class="post-add-icon inline-items">
                            <svg class="olymp-share-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-share-icon"></use></svg>
                            <span>{{ post.comments.length }}</span>
                        </a>
                    </div>
                </div>

                <div class="control-block-button post-control-button">
                    <a href="#" class="btn btn-control">
                        <svg class="olymp-like-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-like-post-icon"></use></svg>
                    </a>

                    <a href="#" class="btn btn-control">
                        <svg class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                    </a>

                    <a href="#" class="btn btn-control">
                        <svg class="olymp-share-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-share-icon"></use></svg>
                    </a>
                </div>

            </article>
        </div>
        <infinite-loading @infinite="infiniteHandler">
            <span slot="no-more">
              There is no more posts
            </span>
        </infinite-loading>
    </div>
</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import InfiniteLoading from 'vue-infinite-loading'
    import axios from 'axios'

    export default {
        components: {VButton, InfiniteLoading},
        props: ['group_id'],
        data: () => ({
            posts: [],
            per_page: 10
        }),
        created(){
            Event.listen("PostNew"+this.group_id, (post) => {
                this.posts.unshift(post);   //add to start

                if(this.posts.length>this.per_page)
                    this.posts.pop();   //delete last element
            })
        },
        methods: {
            infiniteHandler($state) {
                axios.get('/groups/'+this.group_id+'/posts', {
                    params: {
                        page: this.posts.length / this.per_page + 1,
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.posts = this.posts.concat(data.data);
                        $state.loaded();

                        if(this.posts.length >=data.total)
                        {
                            $state.complete();
                        }
                    } else {
                        $state.complete();
                    }
                });
            },
        }
    }
</script>