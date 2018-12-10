<template>
    <div>
        <vue-slider :ref="reff" v-model="avalJson" :min="min" :max="max"
                    @callback="onchange"
        ></vue-slider>
        <input type="hidden" :name="name+'_from'" v-model="from">
        <input type="hidden" :name="name+'_to'" v-model="to">
    </div>
</template>
<script>
    import vueSlider from 'vue-slider-component'

    export default {
        components: {vueSlider},
        props: {
            aval: {
                type: String
            },
            min: {
                type: Number
            },
            max: {
                type: Number
            },
            reff: {
                type: String
            },
            name: {
                type: String
            }
        },
        computed: {
            avalJson: function(){
                return JSON.parse(this.aval);
            }
        },
        data: () => ({
            from: this.avalJson ? this.avalJson[0] : parseInt(this.min),
            to: this.avalJson ? this.avalJson[1] : parseInt(this.max)
        }),
        created() {
            this.from = this.avalJson[0];
            this.to = this.avalJson[1];
        },
        methods: {
            onchange(value)
            {
                this.from = value[0];
                this.to = value[1];
            }
        },
        watch: {
            aval: function(value) {
                this.from = value[0];
                this.to = value[1];
            }
        }
    }
</script>