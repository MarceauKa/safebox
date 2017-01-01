<style scoped>
    #modal-show-site h3 {
        margin-top: 0;
    }
    #modal-show-site .thumbnail img {
        min-width: 100%;
        min-height: 80px;
    }
    #modal-show-site .thumbnail {
        padding: 0;
    }
    #modal-show-site .thumbnail p {
        margin-bottom: 0;
    }
</style>
<template>
    <div>
        <!-- Modal Show -->
        <div class="modal fade" id="modal-show-site" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('sites.singular') }} - {{ site.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="thumbnail">
                                    <img :src="site.screenshot_url" class="img-responsive" alt="Website preview">
                                    <div class="caption">
                                        <p class="text-center">
                                            <a :href="site.url" class="btn btn-sm btn-info" target="_blank">{{ $t('app.button_visit') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <dl>
                                    <dt>{{ $t('sites.url') }}</dt>
                                    <dd><a :href="site.url" target="_blank">{{ site.url }}</a></dd>
                                    <dt>{{ $t('clients.singular') }}</dt>
                                    <dd><a @click="showClient(site.client)" data-dismiss="modal" v-if="site.client">{{ site.client.name }}</a></dd>
                                </dl>
                                <accounts :site-id="site.id" v-if="site.id"></accounts>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="showEdit(site)">{{ $t('app.button_edit') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal create / edit -->
        <div class="modal fade" id="modal-form-site" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="creating">{{ $t('sites.title_create') }}</h4>
                        <h4 class="modal-title" v-if="editing">{{ $t('sites.title_edit') }} - {{ form.name }}</h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p>{{ $t('app.validation_error') }}</p>
                            <ul>
                                <li v-for="error in form.errors">{{ error }}</li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('sites.name') }}</label>
                                <div class="col-md-7">
                                    <input id="input-site-name" type="text" class="form-control" v-model="form.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('sites.url') }}</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url" v-model="form.url">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('sites.client') }}</label>
                                <div class="col-md-7">
                                    <select name="client_id" class="form-control" v-model="form.client_id">
                                        <option value="">{{ $t('app.option_choose') }}</option>
                                        <option v-for="client in clients" :value="client.id">{{ client.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" @click="showHistory(form)" v-if="editing">{{ $t('app.button_history') }}</button>
                            <button type="button" class="btn btn-primary" @click="save">{{ $t('app.button_save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal history -->
        <div class="modal fade" id="modal-site-history" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('app.button_history') }} - {{ site.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="history.length > 0">
                            <div v-for="dates in history">
                                <h4>{{ dates.date }}</h4>
                                <table class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>{{ $t('history.field') }}</th>
                                        <th>{{ $t('history.from') }}</th>
                                        <th>{{ $t('history.to') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="entry in dates.entries">
                                        <td>{{ entry.key | capitalize }}</td>
                                        <td><code>{{ entry.old_value }}</code></td>
                                        <td><code>{{ entry.new_value }}</code></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="alert alert-info" v-if="history.length == 0">{{ $t('history.empty') }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="showEdit(site)">{{ $t('app.button_edit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import clientMixins from '../mixins/clients';

    export default {

        mixins: [clientMixins],

        data() {
            return {
                creating: false,
                editing: false,
                site: {
                    client: {}
                },
                clients: {},
                history: [],
                form: {
                    errors: [],
                    name: '',
                    url: '',
                    client_id: ''
                }
            };
        },

        mounted() {
            eventBus.$on('siteEntryShow', (site) => {
                this.show(site);
            });

            eventBus.$on('siteEntryCreate', () => {
                this.showCreate();
            });

            eventBus.$on('siteEntryEdit', (site) => {
                this.showEdit(site);
            });

            eventBus.$on('siteEntryDelete', (site) => {
                this.delete(site);
            });

            eventBus.$on('siteHistoryShow', (site) => {
                this.showHistory(site);
            });

            this.getClients();

            $('#modal-form-site').on('shown.bs.modal', () => {
                $('#input-site-name').focus();
            });
        },

        methods: {

            getClients() {
                this.$http.get('/api/clients/list')
                        .then(response => {
                            this.clients = response.data;
                        });
            },

            show(site) {
                this.$http['get']('/api/sites/' + site.id)
                        .then(response => {
                            this.site = response.data;
                            $('#modal-show-site').modal('show');
                        })
                        .catch(response => {
                            console.log(response);
                        });
            },

            showCreate() {
                this.creating = true;
                this.editing  = false;

                this.form = {
                    errors: [],
                    name: '',
                    url: '',
                    client_id: ''
                };

                $('#modal-form-site').modal('show');
            },

            showHistory(site) {
                this.$http['get']('/api/sites/history/' + site.id)
                        .then(response => {
                            this.site = response.data.site;
                            this.history = response.data.history;
                            $('#modal-site-history').modal('show');
                        })
                        .catch(response => {
                            console.log(response);
                        });
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/sites/' + this.form.id, this.form, '#modal-form-site');
                } else if (this.creating) {
                    this.persist('post', '/api/sites', this.form, '#modal-form-site');
                }
            },

            showEdit(site) {
                this.editing = true;
                this.creating = false;

                this.form.id = site.id;
                this.form.name = site.name;
                this.form.url = site.url;
                this.form.client_id = site.client_id;

                $('#modal-form-site').modal('show');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        this.editing = false;
                        this.creating = false;
                        eventBus.$emit('sitesRefresh');
                        $(modal).modal('hide');
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            delete(site) {
                this.$http.delete('/api/sites/' + site.id).then(response => {
                    eventBus.$emit('sitesRefresh');
                });
            }
        }
    }
</script>