
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

import VueMaterial from 'vue-material'
//import 'vue-material/dist/vue-material.min.css'
Vue.use(VueMaterial)

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

import moment from 'moment'
Vue.prototype.moment = moment
import Cookies from 'js-cookie'
import Echo from "laravel-echo"
window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6004'//+window.Laravel.echoPort
});

/**
 **  Filters
 ***/
var truncateFilter = function(text, length, clamp){
    clamp = clamp || '...';
    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
};
Vue.filter('truncate', truncateFilter);

/**
 **  Event bus
 **/
window.Event = new class {

    constructor() {
        this.vue = new Vue()
    }

    fire(event, data = null) {
        this.vue.$emit(event, data)
    }

    listen(event, callback) {
        this.vue.$on(event, callback)
    }
}


/**
 ** Global methods
 **/
Vue.mixin({
    methods: {
        getImageLink(image, t = false)
        {
            if(image!==undefined && image!=null && image!="")
            {
                if(!image.includes("http:") && !image.includes("https:"))
                {
                    image = '/storage/'+image;
                }
            }else{

                if(t)
                {
                    switch(t)
                    {
                        case 'overlay_team':
                            image = '/storage/default/overlay_team.jpg';
                            break;
                        case 'overlay_game':
                            image = '/storage/default/overlay_game.jpg';
                            break;
                        case 'overlay_user':
                            image = '/storage/default/overlay_user.jpg';
                            break;

                        case 'avatar_user':
                            image = '/storage/default/avatar_user.jpg';
                            break;
                        case 'avatar_team':
                            image = '/storage/default/avatar_team.jpg';
                            break;
                    }
                }else{
                    image = '/storage/default/avatar_user.jpg';
                }

            }

            return image;
        },
        updateUrlParameter(urlQueryString, key, value)
        {
            var newParam = key + '=' + value,
                params = '?' + newParam;

            var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
            var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

            if(urlQueryString)
            {
                if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty

                    params = urlQueryString.replace(removeRegex, "$1");
                    params = params.replace( /[&;]$/, "" );

                } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it

                    params = urlQueryString.replace(updateRegex, "$1" + newParam);

                } else { // Otherwise, add it to end of query string

                    params = urlQueryString + '&' + newParam;
                }
            }else{
                params = '?' + newParam;
            }

            return params;
        },
        UrlToArray: function(url) {
            var request = {};
            var pairs = url.substring(url.indexOf('?') + 1).split('&');
            for (var i = 0; i < pairs.length; i++) {
                if(!pairs[i])
                    continue;
                var pair = pairs[i].split('=');
                request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
            }
            return request;
        },
        ArrayToUrl: function(array) {
            var pairs = [];
            for (var key in array)
                if (array.hasOwnProperty(key))

                    pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(array[key]));
            return pairs.join('&');
        },
        UrlParamsMerge: function(queryStartParams)
        {
            if(location.search)
            {
                var paramsArray = this.UrlToArray(location.search);

                for (var prop in paramsArray)
                {
                    if (paramsArray.hasOwnProperty(prop))
                    {
                        queryStartParams[prop] = paramsArray[prop];
                    }
                }

                if(parseInt(paramsArray['_limit'])>0)
                    paramsArray['_offset'] = (parseInt(paramsArray['page'])-1)*parseInt(paramsArray['_limit']);
            }

            var query = this.ArrayToUrl(queryStartParams);

            return query;
        },
        materialInit()
        {
            $.material.init();
            $('.checkbox > label').on('click', function () {
                $(this).closest('.checkbox').addClass('clicked');
            });
        }
    }
});
