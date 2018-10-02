<template>
    <div id="newsfeed-items-grid">
        <post :user="user" :post="post" v-for="post in posts" v-if="posts!=null && posts.length>0"/>

        <infinite-loading @infinite="infiniteHandler">
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
        props: ['group_id', 'user'],
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
            }
        }
    }
</script>