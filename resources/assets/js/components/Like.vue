<template>
    <a href="#" class="post-add-icon inline-items" v-bind:class="{'active': checkUserLiked()}" @click.prevent="makeLike">
        <svg class="olymp-heart-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-heart-icon"></use></svg>
        <span>{{ likes.length }}</span>
    </a>

    <!--<ul class="friends-harmonic">
        <li v-for="like in likes" v-if="likes!=null && likes.length>0">
            <a href="#">
                <img :src="getImageLink(like.user.avatar)" :alt="like.user.name" width="36">
            </a>
        </li>
    </ul>

    <div class="names-people-likes">
        <a href="#">Jenny</a>, <a href="#">Robert</a> and
        <br>18 more liked this
    </div>-->
</template>

<script>
    export default {
        props: ['likeable_type', 'likeable_id', 'likes', 'user'],
        methods: {
            makeLike()
            {
                axios.post('/likes', {
                    likeable_type: this.likeable_type,
                    likeable_id: this.likeable_id
                }).then(({ data }) => {

                    if(this.checkUserLiked())
                    {
                        var user_id = this.user.id;

                        if(this.likes!=undefined && this.likes.length>0) {
                            this.likes = this.likes.filter(function (d) {
                                return d.user_id != user_id;
                            });
                        }

                    }else{
                        this.likes.push(data.data);
                    }
                });
            },
            checkUserLiked()
            {
                if(this.likes!=undefined && this.likes.length>0)
                {
                    for (var i = 0; i < this.likes.length; i++)
                    {
                        if (this.likes[i].user_id == this.user.id)
                        {
                            return true;
                        }
                    }
                }

                return false;
            }
        }
    }
</script>