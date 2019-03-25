<template>
    <form class="search-bar w-search notification-list friend-requests">
        <div class="form-group with-button">
            <vue-bootstrap-typeahead
                class="form-control"
                v-model="query"
                :data="users"
                :serializer="item => (item.name ? item.name : item.title)"
                placeholder="Search here people or universities..."
                prepend=""
                @hit="selectUser($event)"
            >
                <!-- Append a button -->
                <template slot="append">
                    <button>
                        <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                    </button>
                </template>

                <!-- Begin custom suggestion slot -->
                <template slot="suggestion" slot-scope="{ data, htmlText }">
                    <div class="d-flex align-items-center" v-if="data.name!=undefined">
                        <img
                            class="rounded-circle"
                            :src="getImageLink(data.avatar)"
                            style="width: 40px; height: 40px;" />
                        <span class="ml-4">{{data.name}}</span>
                    </div>
                    <div class="d-flex align-items-center" v-else>
                        <img
                            class="rounded-circle"
                            :src="getImageLink(data.image)"
                            style="width: 40px; height: 40px;" />
                        <span class="ml-4">{{data.title}}</span>
                    </div>
                </template>
            </vue-bootstrap-typeahead>
        </div>
    </form>
</template>

<script>
    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'

    export default {
        components: {
            VueBootstrapTypeahead
        },
        data() {
            return {
                query: '',
                selectedUser: null,
                users: []
            }
        },
        methods: {
            selectUser(data)
            {
                if(data.nickname!=undefined)
                {
                    window.location.href = '/users/'+data.nickname;
                }else{
                    window.location.href = '/universities/'+data.slug;
                }
            }
        },
        watch: {
            query(newQuery) {
                axios.get('/api/search?q='+newQuery)
                    .then((res) => {
                        this.users = res.data
                    })
            }
        },
        filters: {
            stringify(value) {
                return JSON.stringify(value, null, 2)
            }
        },
    }
</script>
