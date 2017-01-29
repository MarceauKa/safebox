<style scoped>
    table.table {
        margin-bottom: 2px;
    }
    table.table caption {
        padding-left: 8px;
    }
    table.table tr td:nth-child(2) {
        max-width: 20%;
        text-align: right;
    }
    span.help-block {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default" :class="{ 'panel-success': has_results }">
            <div class="panel-heading">{{ $t('search.title') }}</div>
            <div class="panel-body">
                <form @submit.prevent class="form-inline" method="POST">
                    <input type="text" class="form-control" style="width: 100%;" :placeholder="$t('search.placeholder')" id="input-search-form" v-model.trim="query" />
                    <span class="help-block">{{ searchIndicator }}</span>
                </form>
            </div>
            <table class="table" v-if="sites.length > 0">
                <caption>{{ $t('search.sites') }}</caption>
                <tbody>
                <tr v-for="site in sites">
                    <td>{{ site.name }}</td>
                    <td><button class="btn btn-primary btn-xs" @click="showSite(site)">{{ $t('app.button_see') }}</button></td>
                </tr>
                </tbody>
            </table>
            <table class="table" v-if="clients.length > 0">
                <caption>{{ $t('search.clients') }}</caption>
                <tbody>
                <tr v-for="client in clients">
                    <td>{{ client.name }}</td>
                    <td><button class="btn btn-primary btn-xs" @click="showClient(client)">{{ $t('app.button_see') }}</button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    import clientMixins from '../mixins/clients';
    import siteMixins from '../mixins/sites';

    export default {

        mixins: [clientMixins, siteMixins],

        data() {
            return {
                searching: false,
                dirtyQuery: false,
                query: '',
                has_results: false,
                sites: [],
                clients: []
            };
        },

        mounted() {
            $('#input-search-form').focus();
        },

        computed: {
            searchIndicator() {
                if (this.searching) {
                    return this.$t('search.indicator_searching');
                } else if (this.dirtyQuery && this.query.length > 0) {
                    return this.$t('search.indicator_typing');
                }

                return '';
            }
        },

        watch: {
            query() {
                this.dirtyQuery = true;
                this.fetch();
            }
        },

        methods: {
            fetch: _.throttle(function() {
                if (this.query.length >= 3) {
                        this.searching = true;
                        this.$http.post('/api/search/all', {query: this.query})
                                .then(response => {
                                    this.sites = response.data.sites.length > 0 ? response.data.sites : [];
                                    this.clients = response.data.clients.length > 0 ? response.data.clients : [];
                                    this.has_results = this.sites.length > 0 || this.clients.length > 0 ? true : false;
                                    this.searching = false;
                                    this.dirtyQuery = false;
                                })
                                .catch(error => { alert(error) });
                }
            }, 250)
        }
    }
</script>