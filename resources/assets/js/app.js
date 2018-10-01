window.Vue = require('vue');

require('./bootstrap');

Vue.component('change-password-component', require('./components/lk/ChangePasswordComponent'));
Vue.component('profiles-component', require('./components/lk/ProfilesComponent'));
Vue.component('profiles-add-component', require('./components/lk/ProfilesAddComponent'));
Vue.component('profiles-edit-component', require('./components/lk/ProfilesEditComponent'));
Vue.component('post-form-component', require('./components/PostFormComponent'));
Vue.component('post-list-component', require('./components/PostListComponent'));

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
