<template>
    <div>
        <select v-model="major_id" name="major_id" class='form-control' id="major_list">
            <option :value="selected.id" selected="selected" v-if="major_id>0 && selected!=null">{{selected.title}}</option>
        </select>
    </div>

</template>


<script>
    import axios from 'axios'
    import Vue from 'vue'

    export default {

        props: ['val'],

        data : function() {
            return {
                major_id: '',
                majors: null,
                selected: null
            }
        },

        created() {
            this.major_id = this.val;

            //if(parseInt(this.major_id)>0)
                this.getPreselectedMajor();
        },

        mounted() {
            Vue.nextTick(() => {
                this.getMajors();
            });
        },
        methods: {

            async getPreselectedMajor()
            {
                await axios.get('/majors/'+this.major_id).then((response) => {
                    this.$set(this, 'selected', response.data);
                });
            },

            getMajors()
            {
                var self = this;

                $("#major_list").select2({
                    ajax: {
                        url: '/majors',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                "title": params.term, // search term
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params)
                        {
                            params.page = params.page || 1;
                            self.$set(self, 'majors', data.data);

                            return {
                                results: data.data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.title
                                    };
                                }),
                                pagination: {
                                    more: (params.page * 50) < data.total
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    minimumInputLength: 3,
                    placeholder: 'type to search major...'
                }).on("change", function (e) {
                    self.major_id = $(e.currentTarget).find("option:selected").val();
                });
            }
        }
    }
</script>