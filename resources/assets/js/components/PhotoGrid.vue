<template>
    <div>
        <div class="grid-component">
            <div class="__image_container" v-bind:style="styles">
                <img :src="'/storage/'+media.id+'/'+media.file_name" :alt="media.file" v-for="(media, index) in images" v-bind:style="styled(media)" v-bind:class="cssed()" @click="clickImage(index)">
                <div v-if="count > 0" @click="clickImage(0)" class="__image_body __quarter __image_count"><p>{{image_excess}}</p></div>
            </div>
        </div>
        <div :class="{ 'vue-lightbox' : !resetstyles }">
            <div class="lightbox-overlay" v-if="overlayActive" @click.self="closeOverlay">
                <div class="holder">
                    <img :src="'/storage/'+images[currentImage].id+'/'+images[currentImage].file_name"/>
                    <div class="nav" v-if="nav">
                        <a class="close" nohref @click="closeOverlay"><span>&times;</span></a>
                        <a class="prev" nohref @click="prevImage"><span>&#8592;</span></a>
                        <a class="next" nohref @click="nextImage"><span>&#8594;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: {
            boxWidth: { type: String, default: 'auto' },
            boxHeight: { type: String, default: '200px' },
            boxBorder: { type: Number, default: 0 },
            excessText: { type: String, default: 'View more {{count}} images'},
            images: {type: Array, default: []},

            resetstyles: {
                default: false,
                type: Boolean,
            },
            loop: {
                default: true,
                type: Boolean,
            },
            nav: {
                default: true,
                type: Boolean,
            },
        },
        data: function(){
            return{
                styles: {
                    width: this.boxWidth,
                    height: this.images.length==1 ? "100%" : this.boxHeight,
                    'border-radius': this.boxBorder + 'px',
                    overflow: 'hidden'
                },
                image_excess: 0,

                currentImage: null,
                overlayActive: false,
            }
        },
        computed: {
            $child() {
                return this.$el;
            },
            countImageLength(){
                return this.images.length
            },
            count(){
                return this.images.length - 4;
            },
        },
        mounted(){
            this.pareseExcessText()

            const self = this;
            window.addEventListener('keydown', (e) => {
                self.handleGlobalKeyDown(e);
            });
        },
        methods: {
            pareseExcessText(){
                this.image_excess = this.excessText.replace('{{count}}', this.images.length - 4);
            },
            styled(media)
            {
                return "background-image: url(/storage/"+media.id+'/'+media.file_name+")";
            },
            cssed()
            {
                let __image_Size = this.images.length;

                var className = "__image_body"
                switch (true) {
                    case (__image_Size == 1):
                        className += " __single"
                        break;
                    case (__image_Size == 3):
                        className += " __triple"
                        break;
                    case (__image_Size == 4):
                        className += " __quarter"
                        break;
                    case (__image_Size > 4):
                        className += " __quarter __more_image"
                        break;
                }

                return className;
            },

            clickImage(index) {
                this.currentImage = index;
                this.overlayActive = true;
            },
            nextImage() {
                if (this.currentImage === (this.images.length - 1)) {
                    if (this.loop) {
                        this.currentImage = 0;
                    }
                } else {
                    this.currentImage += 1;
                }
            },
            prevImage() {
                if (this.currentImage === 0) {
                    if (this.loop) {
                        this.currentImage = (this.images.length - 1);
                    }
                } else {
                    this.currentImage -= 1;
                }
            },
            closeOverlay() {
                this.overlayActive = false;
            },
            handleGlobalKeyDown(e) {
                switch (e.keyCode) {
                    case 37: this.prevImage(); break;
                    case 39: this.nextImage(); break;
                    case 27: this.closeOverlay(); break;
                    default: break;
                }
            },
        }
    }
</script>

<style scoped>
    .__image_container{
        height: 200px;
        width: 200px;
        display: inline-block;
        position: relative;
    }
    .__image_body:first-child, .__image_body:last-child, .__image_body.__quarter:nth-child(3){
        float: left;
    }
    .__image_body.__single{
        width: 100%;
        height: 100%;
    }
    .__image_body.__triple, .__image_body.__quarter{
        height: 50%;
    }
    .__image_body.__triple:nth-child(2), .__image_body.__quarter:nth-child(2),
    .__image_body.__quarter:last-child, .__image_body.__more_image:nth-child(4){
        float: right;
    }
    .__image_count{
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center;
        position: absolute;
        bottom: 0;
        color: #fff;
        font-size: 1em;
        background: rgba(0, 0, 0, 0.5) !important;
    }
    .__image_body.__triple:first-child{
        height: 100%;
    }
    .__image_body{
        width: 50%;
        height: 100%;
        background: #d8d8d8;
        object-fit: cover;
        display: inline;
    }
</style>


<style scoped lang="scss">
    .vue-lightbox ul {
        list-style: none;
        margin: 0 auto;
        padding: 0;
        display: block;
        max-width: 780px;
        text-align: center;

        li {
            display: inline-block;
            padding: 5px;
            background: ghostwhite;
            margin: 10px;

            img {
                display: block;
                width: 200px;
            }
        }
    }
    .lightbox-overlay {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0,0,0,0.9);
        text-align: center;
        padding: 20px;
        box-sizing: border-box;
        z-index: 100;

        .holder {
            width: 100%;
            height: 100%;
            position: relative;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;

            img {
                width: auto;
                max-width: 600px;
                cursor: pointer;
                box-sizing: border-box;
                display: block;
                max-height: 100vh;
                margin: 0 auto;
            }

            p {
                color: #ffffff;
                margin: 0;
                background-color: rgba(0,0,0,0.4);
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                box-sizing: border-box;
                padding: 10px;
            }
            .nav {
                max-width: 600px;
                margin: 0 auto;
                font-size: 14px;
                a {
                    color: white;
                    opacity: 0.3;
                    -webkit-user-select: none;
                    cursor: pointer;
                    margin: 0;
                    float: none;
                    height: auto;
                    padding: 0;
                    margin: 0;

                    &:hover {
                        opacity: 1;
                    }

                    span{
                        float: none;
                        padding: 0;
                        overflow: inherit;
                    }
                }

                .next, .prev {
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    padding: 10px;
                    width: 50%;
                    box-sizing: border-box;
                    font-size: 40px;
                    span {
                        top: 50%;
                        transform: translateY(50%);
                        position: relative;
                    }
                }
                .next {
                    right: 0;
                    text-align: right;
                }
                .prev {
                    left: 0;
                    text-align: left;
                }
                .close {
                    right: 10px;
                    top: 0;
                    font-size: 30px;
                    opacity: 0.6;
                    z-index: 1000000;
                    position: absolute;
                    text-align: left;
                    box-sizing: border-box;

                    &:hover {
                        opacity: 1;
                    }
                }
            }
        }
    }
</style>