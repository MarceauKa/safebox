/**
 * Deps
 */
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

/**
 * Vue
 */
window.Vue = require('vue');
require('vue-resource');

/**
 * Events
 */
window.eventBus = new Vue();

/**
 * i18n
 */
Vue.use(require('vue-i18n'));
Vue.config.lang = $('meta[name="app-locale"]:eq(0)').attr('content');
Vue.locale('en', require('./lang/en'));
Vue.locale('fr', require('./lang/fr'));

/**
 * HTTP
 */
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]:eq(0)').attr('content'));
    request.headers.set('Authorization', 'Bearer ' + $('meta[name="api-token"]:eq(0)').attr('content'));

    next();
});

/**
 * Filters
 */
Vue.filter('capitalize', function (value) {
    return _.capitalize(value);
});

/**
 * Components
 */
Vue.component('search', require('./components/Search.vue'));
Vue.component('password', require('./components/Password.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('client-entry', require('./components/ClientEntry.vue'));
Vue.component('site-entry', require('./components/SiteEntry.vue'));
Vue.component('account-entry', require('./components/AccountEntry.vue'));
Vue.component('clients', require('./components/Clients.vue'));
Vue.component('sites', require('./components/Sites.vue'));
Vue.component('accounts', require('./components/Accounts.vue'));

/**
 * Vue Instance
 */
const app = new Vue({
    el: '#app'
});
