<template>

    <div class="news-feed-form">
        <alert-success :form="form" :message="message"/>
        <alert-errors :form="form"/>
        <form @submit.prevent="save" @keydown="form.onKeydown($event)">
            <div class="author-thumb">
                <img :src="getImageLink(group.image)" :alt="group.title" v-if="group && group.owner_id==user.id">
                <img :src="getImageLink(user.avatar)" :alt="user.name" v-else>
            </div>
            <!--<div class="form-group with-icon label-floating">-->
            <div class="form-group label-floating">
                <textarea @input="onInput" v-model="form.text" :class="{ 'is-invalid': form.errors.has('text') }" class="form-control" placeholder="Share what you are thinking here..."></textarea>

                <emoji-picker @emoji="append" :search="search">
                    <div
                        class="emoji-invoker"
                        slot="emoji-invoker"
                        slot-scope="{ events }"
                        v-on="events"
                    >
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                        </svg>
                    </div>
                    <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
                        <div class="emoji-picker">
                            <div v-for="(emojiGroup, category) in emojis" :key="category" class="mb-2">
                                <h5>{{ category }}</h5>
                                <div class="emojis">
                                    <span
                                        v-for="(emoji, emojiName) in emojiGroup"
                                        :key="emojiName"
                                        @click="insert(emoji)"
                                        :title="emojiName"
                                    >{{ emoji }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </emoji-picker>

                <has-error :form="form" field="text"/>
            </div>

            <div class="table-responsive" v-if="files!=null && files.length>0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Uploading</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(file, index) in files" :key="file.id">
                        <td>
                            <img v-if="file.thumb" :src="file.thumb" width="60" height="auto" />
                            <span v-else>No Image</span>
                        </td>
                        <td>
                            <div class="progress" v-if="file.active || file.progress !== '0.00'">
                                <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
                            </div>
                            <div class="filename">
                                {{file.name}}
                            </div>
                        </td>
                        <td v-if="file.error">{{file.error}}</td>
                        <td v-else-if="file.success">success</td>
                        <td v-else-if="file.active">active</td>
                        <td v-else></td>
                        <td>
                            <a class="btn-md-2" href="#" @click.prevent="$refs.upload.remove(file)">Remove</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="links" v-if="links!=null && links.length>0">
                <link-preview :url="link" v-for="link in links" :key="link" @newLinkParsed="onNewLinkParsed">
                </link-preview>
            </div>

            <div class="add-options-message">

                <file-upload
                        class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD PHOTOS"
                        :post-action="postAction"
                        :extensions="extensions"
                        :accept="accept"
                        :multiple="multiple"
                        :directory="directory"
                        :size="size || 0"
                        :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
                        :headers="headers"
                        :data="data"
                        :drop="drop"
                        :drop-directory="dropDirectory"
                        :add-index="addIndex"
                        v-model="files"
                        @input-filter="inputFilter"
                        @input-file="inputFile"
                        ref="upload">
                    <img src="/svg-icons/sprites/Photo.svg" style="width: 22px; height: 22px;">
                </file-upload>

                <!--<a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="TAG YOUR FRIENDS">
                    <svg class="olymp-computer-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-computer-icon"></use></svg>
                </a>

                <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD LOCATION">
                    <svg class="olymp-small-pin-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-small-pin-icon"></use></svg>
                </a>-->

                <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post</v-button>
            </div>
        </form>

        <!--<form @submit.prevent="save" @keydown="form.onKeydown($event)"  class="comment-form inline-items">
            <alert-success :form="form" :message="message"/>
            <div class="post__author author vcard inline-items">
                <img :src="getImageLink(user.avatar)" :alt="user.name" width="36">

                <div class="form-group">
                    <textarea v-model="form.text" class="form-control" placeholder=""></textarea>

                    <div class="add-options-message">
                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD PHOTOS">
                            <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-camera-icon"></use></svg>
                        </a>
                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="TAG YOUR FRIENDS">
                            <svg class="olymp-computer-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-computer-icon"></use></svg>
                        </a>

                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top"   data-original-title="ADD LOCATION">
                            <svg class="olymp-small-pin-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-small-pin-icon"></use></svg>
                        </a>
                    </div>
                </div>
            </div>

            <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post</v-button>
        </form>-->
    </div>


</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import EmojiPicker from 'vue-emoji-picker'
    import FileUpload from 'vue-upload-component'
    import axios from 'axios'

    export default {
        components: {
            VButton,
            EmojiPicker,
            FileUpload
        },
        props: ['user', 'group'],
        data: () => ({
            group_id : 0,
            form: new Form({
                text: ''
            }),
            search: '',
            message: null,
            links: [],
            parsedLinks: [],
            files: [],
            accept: 'image/png,image/gif,image/jpeg,image/webp',
            extensions: 'gif,jpg,jpeg,png,webp',
            minSize: 1024,
            size: 1024 * 1024 * 10,
            multiple: true,
            directory: false,
            drop: true,
            dropDirectory: true,
            addIndex: false,
            thread: 3,
            name: 'file',
            postAction: '/upload',
            putAction: '/upload',
            headers: {
                'X-Csrf-Token': document.head.querySelector('meta[name="csrf-token"]').content
            },
            data: {
                '_csrf_token': document.head.querySelector('meta[name="csrf-token"]').content,
            },
            autoCompress: 1024 * 1024,
            uploadAuto: true,
            isOption: false,

    }),
        created(){
            this.group_id = this.group ? this.group.id : 0;
        },
        methods: {
            save()
            {
                this.form.group_id = this.group_id;
                this.form.images = [];

                if(this.files.length>0)
                {
                    for (var i = 0; i < this.files.length; i++)
                    {
                        this.form.images.push(this.files[i].response.data);
                    }
                }

                if(this.links.length>0)
                {
                    this.form.links = [];
                    for (var i = 0; i < this.links.length; i++)
                    {
                        for (var k = 0; k < this.parsedLinks.length; k++)
                        {
                            if(this.links[i]==this.parsedLinks[k].url)
                            {
                                this.form.links.push(this.parsedLinks[k]);
                                break;
                            }
                        }
                    }
                }

                this.form.post('/posts')
                    .then(({ data }) => {
                        this.message = data.message;
                        Event.fire("PostNew"+this.group_id, data.data);
                        this.form.reset();
                        this.files = [];
                        this.links = [];
                        this.parsedLinks = [];
                    })
            },
            onInput(event) {
                this.links = this.getURLsFromString(this.form.text);
            },
            append(emoji) {
                this.form.text += emoji
            },
            getURLsFromString(text) {
                var re = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=+$,\w]+@)?[A-Za-z0-9.-]+|(?:www\.|[-;:&=+$,\w]+@)[A-Za-z0-9.-]+)((?:\/[+~%\/.\w-]*)?\??(?:[-+=&;%@.\w]*)#?\w*)?)/gm;
                var m;
                var arr = [];
                while ((m = re.exec(text)) !== null) {
                    if (m.index === re.lastIndex) {
                        re.lastIndex++;
                    }
                    arr.push(m[0]);
                }

                arr = arr.filter(function onlyUnique(value, index, self) {
                    return self.indexOf(value) === index;
                });
                return arr;
            },
            /**
             * Has changed
             * @param  Object|undefined   newFile   Read only
             * @param  Object|undefined   oldFile   Read only
             * @return undefined
             */
            // add, update, remove File Event
            inputFile(newFile, oldFile) {
                if (newFile && oldFile) {
                    // update
                    if (newFile.active && !oldFile.active) {
                        // beforeSend
                        // min size
                        if (newFile.size >= 0 && this.minSize > 0 && newFile.size < this.minSize) {
                            this.$refs.upload.update(newFile, { error: 'size' })
                        }
                    }
                    if (newFile.progress !== oldFile.progress) {
                        // progress
                    }
                    if (newFile.error && !oldFile.error) {
                        // error
                    }
                    if (newFile.success && !oldFile.success) {
                        // success
                    }
                }
                if (!newFile && oldFile) {

                    // remove
                    if (oldFile.success && oldFile.response.data) {
                        axios.delete('/upload', {
                            data: {
                                image: oldFile.response.data
                            }
                        }).then(({ data }) => {
                            return false;
                        });
                    }
                }
                // Automatically activate upload
                if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
                    if (this.uploadAuto && !this.$refs.upload.active) {
                        this.$refs.upload.active = true
                    }
                }
            },
            inputFilter(newFile, oldFile, prevent) {

                if (newFile && !oldFile) {
                    // Filter non-image file
                    if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                        return prevent()
                    }
                }

                if (newFile && (!oldFile || newFile.file !== oldFile.file))
                {
                    // Create a blob field
                    newFile.blob = ''
                    let URL = window.URL || window.webkitURL
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file)
                    }

                    // Thumbnails
                    newFile.thumb = ''
                    if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                        newFile.thumb = newFile.blob
                    }
                }
            },
            onNewLinkParsed(prevue) {
                if(prevue!==null)
                    this.parsedLinks.push(prevue);
            }
        },
        directives: {
            focus: {
                inserted(el) {
                    el.focus()
                },
            },
        }
    }
</script>
