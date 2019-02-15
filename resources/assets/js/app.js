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
Vue.component('chat-notify-icon', require('./components/ChatNotifyIcon'));
Vue.component('pin-popup-google-map', require('./components/PinPopupGoogleMap'))
Vue.component('popup-google-map', require('./components/PopupGoogleMap'))
Vue.component('repost-popup', require('./components/RepostPopup'))
Vue.component('photo-grid', require('./components/PhotoGrid'))

Vue.component('friend-list', require('./components/FriendList'));
Vue.component('friend-possible-search', require('./components/FriendPossibleSearch'));
Vue.component('friend-possible-widget', require('./components/FriendPossibleWidget'));
Vue.component('friend-requests-in', require('./components/FriendRequestsIn'));
Vue.component('friend-requests-out', require('./components/FriendRequestsOut'));
Vue.component('range-slider', require('./components/RangeSlider'));

Vue.component('major-select', require('./components/MajorSelect'));
Vue.component('register-coach', require('./components/RegisterCoach'));
Vue.component('register-athlete', require('./components/RegisterAthlete'));

import Datepicker from 'vuejs-datepicker'
Vue.component('datepicker', Datepicker)

Vue.component('link-preview', require('./components/LinkPreview'))
Vue.component('university-games', require('./components/UniversityGames'));
Vue.component('university-game-add', require('./components/UniversityGameAdd'));
Vue.component('university-vacancies', require('./components/UniversityVacancies'));
Vue.component('university-vacancy-add', require('./components/UniversityVacancyAdd'));

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
