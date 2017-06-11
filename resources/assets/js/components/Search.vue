<style lang="less" scoped>
    div.panel-heading {
        padding: 0;
        border-bottom: 0;

        form {
            input {
                border: none;
            }

            .help-block {
                position: absolute;
                top: 7px;
                right: 30px;
                margin-top: 0;
            }
        }
    }
    div.panel-body {
        padding: 0;

        table.table {
            margin-bottom: 0;

            tbody {
                td {
                    border: none;
                }
            }
        }
    }
    .slide-fade-enter-active,
    .slide-fade-leave-active {
        transition: all .3s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateY(10px);
        opacity: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <form @submit.prevent class="form-inline" method="POST">
                    <input type="text" class="form-control" style="width: 100%;" :placeholder="$t('search.placeholder')" id="input-search-form" v-model.trim="query" />
                    <transition name="slide-fade">
                        <span class="help-block pull-right" v-if="searchIndicator">{{ searchIndicator }}</span>
                    </transition>
                    <transition name="slide-fade">
                        <span class="help-block pull-right" v-if="showClearButton">
                            <button class="btn btn-xs btn-link" @click="clear()">{{ $t('search.button_clear') }}</button>
                        </span>
                    </transition>
                </form>
            </div>
            <div class="panel-body" v-if="showResults">
                <table class="table">
                    <tbody>
                    <tr v-for="site in sites">
                        <td>{{ site.name }}</td>
                        <td class="col-xs-3">{{ site.url }}</td>
                        <td class="col-xs-3"><span class="badge badge-primary">{{ $t('search.sites') }}</span></td>
                        <td class="col-xs-3 text-right"><button class="btn btn-primary btn-xs" @click="showSite(site)">{{ $t('app.button_see') }}</button></td>
                    </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tbody>
                    <tr v-for="client in clients">
                        <td>{{ client.name }}</td>
                        <td class="col-xs-3">{{ client.email }}</td>
                        <td class="col-xs-3"><span class="badge badge-success">{{ $t('search.clients') }}</span></td>
                        <td class="col-xs-3 text-right"><button class="btn btn-primary btn-xs" @click="showClient(client)">{{ $t('app.button_see') }}</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
            },
            showClearButton() {
                return this.showResults && ! this.dirtyQuery;
            },
            showResults() {
                return this.sites.length > 0 || this.clients.length > 0;
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
            }, 250),

            clear() {
                this.sites = [];
                this.clients = [];
                this.query = '';
            }
        }
    }
</script>