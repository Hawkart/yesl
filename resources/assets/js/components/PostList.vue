<template>
    <div id="newsfeed-items-grid">
        <post :user="user" :post="post" v-for="post in posts" :key="post.id" v-if="posts!=null && posts.length>0"/>

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
        props: ['group', 'user', 'type'],
        data: () => ({
            group_id : 0,
            posts: [],
            per_page: 10
        }),
        created(){
            this.group_id = this.group ? this.group.id : 0;

            Event.listen("PostNew"+this.group_id, (post) => {
                this.posts.unshift(post);   //add to start

                if(this.posts.length>this.per_page)
                    this.posts.pop();   //delete last element
            })
        },
        methods: {
            infiniteHandler($state) {

                if(this.type=='wall')
                {
                    var url = '/users/'+this.user.id+'/wall';
                }else if(this.type=='group')
                {
                    var url = '/groups/'+this.group.id+'/posts';
                }

                axios.get(url, {
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