window.Vue = require('vue');

require('./bootstrap');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('change-password-component', require('./components/lk/ChangePasswordComponent'));
Vue.component('profiles-component', require('./components/lk/ProfilesComponent'));
Vue.component('profiles-add-component', require('./components/lk/ProfilesAddComponent'));

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
