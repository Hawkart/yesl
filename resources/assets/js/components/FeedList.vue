<template>
    <div id="newsfeed-items-grid">
        <post :user="user" :post="post" v-for="post in posts" :key="post.id" v-if="posts!=null && posts.length>0"/>

        <infinite-loading @infinite="infiniteHandler">
            <span slot="no-results">
              There is no news yet :(
            </span>
            <span slot="no-more">
              There is no more posts
            </span>
        </infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading'
    import axios from 'axios'

    export default {
        components: {InfiniteLoading},
        props: ['user'],
        data: () => ({
            posts: [],
            per_page: 10
        }),
        methods: {
            infiniteHandler($state) {
                axios.get('/users/'+this.user.id+'/feeds', {
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
            }
        }
    }
</script>