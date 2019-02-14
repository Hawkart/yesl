<template>
    <form @submit.prevent="save" @keydown="form.onKeydown($event)" class="comment-form inline-items" :id="'comment-form-'+post_id">

        <alert-success :form="form" :message="message" class="w-100"/>
        <alert-errors :form="form" class="w-100"/>

        <div class="post__author author vcard inline-items">
            <img :src="getImageLink(group.image)" :alt="group.title" width="36" v-if="group && user.id==group.owner_id">
            <img :src="getImageLink(user.avatar)" :alt="user.name" width="36" v-else>

            <div class="form-group with-icon-right">
                <textarea v-model="form.comment" @change="onInput" :class="{ 'is-invalid': form.errors.has('comment') }" name="comment" class="form-control" placeholder="Add the comment..."></textarea>
                <has-error :form="form" field="comment"/>
                <div class="add-options-message border-0">
                    <file-upload
                            class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD PHOTOS"
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
                            ref="comment">
                        <img src="/svg-icons/sprites/Photo.svg" style="width: 22px; height: 22px;">
                    </file-upload>
                </div>
            </div>
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

        <div class="links pa-0" v-if="links!=null && links.length>0">
            <link-preview :url="link" v-for="link in links" :key="link" @newLinkParsed="onNewLinkParsed">
            </link-preview>
        </div>

        <v-button :loading="form.busy" type="primary" :large="false" additional="btn-md-2">Post Comment</v-button>
        <div class="reply_on btn-md-2 c-grey btn-transparent custom-color" v-if="reply_on!==undefined && reply_on.id>0">
            {{reply_on.user.name}}
            <a href="#" class="close-reply" @click.prevent="deleteReply">
                <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
            </a>
        </div>
    </form>
</template>

<script>
    import Form from 'vform'
    import VButton from "./Button"
    import VueEmoji from 'emoji-vue'
    import FileUpload from 'vue-upload-component'
    import axios from 'axios'

    export default {
        components: {
            VButton,
            VueEmoji,
            FileUpload
        },
        props: ['post_id', 'user', 'reply', 'group'],
        data: () => ({
            form: new Form({
                comment: ''
            }),
            message: null,
            comment: '',
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
            reply_on: this.reply
        }),
        methods: {
            save()
            {
                this.form.post_id = this.post_id;

                if(this.reply_on!=null && this.reply_on.id!==null)
                {
                    this.form.reply_id = this.reply_on.id;
                }else{
                    this.form.reply_id = 0;
                }

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

                this.form.post('/comments')
                    .then(({ data }) => {
                        this.message = data.message;
                        Event.fire("CommentNew"+this.post_id, data.data);
                        this.form.reset();
                        this.files = [];
                        this.links = [];
                        this.parsedLinks = [];
                        this.$emit('deleteReply');
                    })
            },
            onInput(event) {
                //this.form.comment = event.data;
                this.links = this.getURLsFromString(this.form.comment);
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
            },
            deleteReply()
            {
                this.$emit('deleteReply');
                //console.log('deleteReply');
                //this.reply_on = [];
                //console.log(this.reply_on);
            }
        },
        watch: {
            reply: function(newVal, oldVal) { // watch it
                this.reply_on = this.reply;
                //console.log('Prop changed: ', newVal, ' | was: ', oldVal)
            }
        }
    }
</script>
