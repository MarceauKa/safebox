
window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

window.Vue = require('vue');
require('vue-resource');

Vue.component(
    'clients',
    require('./components/Clients.vue')
);

Vue.component(
    'sites',
    require('./components/Sites.vue')
);

Vue.component(
    'accounts',
    require('./components/Accounts.vue')
);


Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]:eq(0)').attr('content'));
    request.headers.set('Authorization', 'Bearer ' + $('meta[name="api-token"]:eq(0)').attr('content'));

    next();
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
