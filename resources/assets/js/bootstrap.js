
window._ = require('lodash')

window.$ = window.jQuery = require('jquery')

require('bootstrap-sass')

window.Vue = require('vue')
require('vue-resource')

window.eventBus = new Vue()

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]:eq(0)').attr('content'))
    request.headers.set('Authorization', 'Bearer ' + $('meta[name="api-token"]:eq(0)').attr('content'))

    next()
});

Vue.filter('capitalize', function (value) {
    return _.capitalize(value)
})

Vue.component('search', require('./components/Search.vue'))
Vue.component('password', require('./components/Password.vue'))
Vue.component('paginator', require('./components/Paginator.vue'))
Vue.component('client-entry', require('./components/ClientEntry.vue'))
Vue.component('site-entry', require('./components/SiteEntry.vue'))
Vue.component('account-entry', require('./components/AccountEntry.vue'))
Vue.component('clients', require('./components/Clients.vue'))
Vue.component('sites', require('./components/Sites.vue'))
Vue.component('accounts', require('./components/Accounts.vue'))
