<template>
    <div class="ui-block">

        <article class="hentry post video">

            <div class="post__author author vcard inline-items">

                <img :src="getImageLink(post.group.image)" :alt="post.group.title" v-if="post.group_id>0 && post.user.id==post.group.owner_id">
                <img :src="getImageLink(post.user.avatar)" :alt="post.user.name" v-else>

                <div class="author-date">

                    <template v-if="post.group_id>0 && post.user.id==post.group.owner_id">
                        <a class="h6 post__author-name fn" :href="'/universities/'+post.group.slug" v-if="post.group.groupable_type=='App\\Models\\University'">{{post.group.title}}</a>
                        <a class="h6 post__author-name fn" :href="'/games/'+post.group.slug" v-else-if="post.group.groupable_type=='App\\Models\\Game'">{{post.group.title}}</a>
                    </template>
                    <template v-else>
                        <a class="h6 post__author-name fn" :href="'/users/'+post.user.nickname">{{post.user.name}}</a><!-- shared a <a href="#">link</a>-->
                    </template>

                    <div class="post__date">
                        <time class="published" datetime="moment.utc(post.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                            {{moment.utc(post.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                        </time>
                    </div>
                </div>

                <!--<div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
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
                </div>-->

            </div>

            <p v-html="post.text"></p>

            <div class="post-block-photo" v-if="post.media!=null && post.media.length>0">
                <photo-grid :box-height="'300px'" :box-width="'100%'" :excess-text="'+ {{count}}'" v-on:clickExcess="triggerClick" :images="post.media"/>
            </div>

            <div class="links" v-if="post.additional!=null && post.additional.links!=null && post.additional.links.length>0">
                <template v-for="link in post.additional.links">
                    <div class="post-video">
                        <div class="embed-responsive embed-responsive-16by9" v-if="link.video!==undefined" v-html="link.video"></div>
                        <div class="video-thumb full-width" v-else>
                            <img :src="link.img" :alt="link.title">
                        </div>

                        <div class="video-content">
                            <h1><a v-bind:href="link.url" class="h4 title">{{link.title}}</a></h1>
                            <p>{{link.description}}</p>
                        </div>
                    </div>
                </template>
            </div>

            <template v-if="post.parent_id>0">
                <ul class="children single-children">
                    <li class="comment-item">

                        <div class="post__author author vcard inline-items">
                            <img :src="getImageLink(post.parent.group.image)" :alt="post.parent.group.title" v-if="post.parent.group_id>0 && post.parent.user.id==post.parent.group.owner_id">
                            <img :src="getImageLink(post.parent.user.avatar)" :alt="post.parent.user.name" v-else>

                            <div class="author-date">
                                <template v-if="post.parent.group && post.parent.user.id==post.parent.group.owner_id">
                                    <a class="h6 post__author-name fn" :href="'/universities/'+post.parent.group.slug" v-if="post.parent.group.groupable_type=='App\\Models\\University'">{{post.parent.group.title}}</a>
                                    <a class="h6 post__author-name fn" :href="'/games/'+post.parent.group.slug" v-else-if="post.parent.group.groupable_type=='App\\Models\\Game'">{{post.parent.group.title}}</a>
                                </template>
                                <template v-else>
                                    <a class="h6 post__author-name fn" :href="'/users/'+post.parent.user.nickname">{{post.parent.user.name}}</a><!-- shared a <a href="#">link</a>-->
                                </template>

                                <div class="post__date">
                                    <time class="published" datetime="moment.utc(post.parent.created_at, 'YYYY-MM-DD h:mm:ss').local().format('YYYY-MM-DD h:mm:ss')">
                                        {{moment.utc(post.parent.created_at, "YYYY-MM-DD h:mm:ss").local().format("MMMM Do, h:mm a") }}
                                    </time>
                                </div>
                            </div>
                        </div>

                        <div class="post-block-photo js-zoom-gallery" v-if="post.parent.media!=null && post.parent.media.length>0">
                            <photo-grid :box-height="'300px'" :box-width="'100%'" :excess-text="'+ {{count}}'" v-on:clickExcess="triggerClick" :images="post.parent.media"/>
                        </div>

                        <p v-html="post.parent.text"></p>

                        <div class="links" v-if="post.parent.additional!=null && post.parent.additional.links!=null && post.parent.additional.links.length>0">
                            <template v-for="link in post.parent.additional.links">
                                <div class="post-video">
                                    <div class="video-thumb mt-lg-4 ml-lg-3">
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

                     </li>
                </ul>
            </template>

            <div class="post-additional-info inline-items">

                <like likeable_type="Post" :likeable_id="post.id" :likes="post.likes" :user="user"/>

                <div class="comments-shared">
                    <a href="#" class="post-add-icon inline-items" @click.prevent="show_comments=!show_comments">
                        <img src="/svg-icons/sprites/Comments_post.svg" title="comment" style="width: 22px; height: 22px;">
                        <span>{{ post.comments.length }}</span>
                    </a>

                    <a href="#" class="post-add-icon inline-items" @click.prevent="makeRepost" data-toggle="modal" data-target="#repost-dialog-form">
                        <img src="/svg-icons/sprites/Repost_post.svg" title="repost" style="width: 22px; height: 22px;">
                        <span>{{post.repostCount}}</span>
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

        <comment-list :comments="post.comments" :post_id="post.id" :group="post.group" :user="user" v-if="show_comments" @setReply="onSetReply"></comment-list>
        <comment-form :post_id="post.id" :group="post.group" :user="user" :reply="reply_on" v-if="show_comments" @deleteReply="onDeleteReply"></comment-form>
    </div>
</template>


<script>
    export default {
        props: ['post', 'user'],
        data: () => ({
            posts: [],
            per_page: 10,
            show_comments: false,
            reply_on: []
        }),
        created(){
            if(this.post.comments.length>0)
                this.show_comments = true;
        },
        methods: {
            onSetReply(comment) {
                this.reply_on = comment;

                var topOfElement = document.querySelector('#comment-form-'+comment.post_id).offsetTop - 10;
                window.scroll({ top: topOfElement, behavior: "smooth" });
            },
            onDeleteReply()
            {
                this.reply_on = [];
            },
            makeRepost() {
                Event.fire('SetRepostPopup', this.post);
            }
        }
    }
</script>
