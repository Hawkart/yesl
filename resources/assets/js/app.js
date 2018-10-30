window.Vue = require('vue');

require('./bootstrap');

Vue.component('change-password-component', require('./components/lk/ChangePasswordComponent'));
Vue.component('profiles-component', require('./components/lk/ProfilesComponent'));
Vue.component('profiles-add-component', require('./components/lk/ProfilesAddComponent'));
Vue.component('profiles-edit-component', require('./components/lk/ProfilesEditComponent'));
Vue.component('post-form', require('./components/PostForm'));
Vue.component('post-list', require('./components/PostList'));
Vue.component('post', require('./components/Post'));
Vue.component('like', require('./components/Like'));
Vue.component('comment-form', require('./components/CommentForm'));
Vue.component('comment-list', require('./components/CommentList.vue'));
Vue.component('comment', require('./components/Comment'));
Vue.component('avatar-upload', require('./components/AvatarUpload'));
Vue.component('overlay-upload', require('./components/OverlayUpload'));
Vue.component('group-subscribe', require('./components/GroupSubscribe'));
Vue.component('feed-list', require('./components/FeedList'));

Vue.component('chat', require('./components/Chat'));
Vue.component('chat-dialog-form', require('./components/ChatDialogForm'));
Vue.component('chat-dialog-button', require('./components/ChatDialogButton'));

import {
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

const app = new Vue({
    el: '#app'
});
