<template>
    <div>
        <!-- Modal show -->
        <div class="modal fade" id="modal-show-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('clients.singular') }} - {{ client.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{ client.name }}<br>
                            <a :href="`mailto:${client.email}`">{{ client.email }}</a><br>
                            <a :href="`tel:${client.phone}`">{{ client.tel }}</a><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                        <button type="button" class="btn btn-primary" @click="showEdit(client)">{{ $t('app.button_edit') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal create / edit -->
        <div class="modal fade" id="modal-form-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="creating">{{ $t('clients.title_create') }}</h4>
                        <h4 class="modal-title" v-if="editing">{{ $t('clients.title_edit') }} : {{ form.name }}</h4>
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
                                <label class="col-md-3 control-label">{{ $t('clients.name') }}</label>
                                <div class="col-md-7">
                                    <input id="input-client-name" type="text" class="form-control" v-model="form.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('clients.email') }}</label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" v-model="form.email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('clients.phone') }}</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="form.phone">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                        <button type="button" class="btn btn-default" @click="showHistory(form)" v-show="editing">{{ $t('app.button_history') }}</button>
                        <button type="button" class="btn btn-primary" @click="save">{{ $t('app.button_save') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal history -->
        <div class="modal fade" id="modal-client-history" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('app.button_history') }} - {{ client.name }}</h4>
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
                        <button type="button" class="btn btn-primary" @click="showEdit(client)">{{ $t('app.button_edit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                creating: false,
                editing: false,
                client: {},
                history: [],
                form: {
                    errors: [],
                    name: '',
                    email: '',
                    phone: ''
                }
            };
        },

        mounted() {
            eventBus.$on('clientEntryShow', (client) => {
                this.show(client);
            });

            eventBus.$on('clientEntryCreate', () => {
                this.showCreate();
            });

            eventBus.$on('clientEntryEdit', (client) => {
                this.showEdit(client);
            });

            eventBus.$on('clientEntryDelete', (client) => {
                this.delete(client);
            });

            eventBus.$on('clientHistoryShow', (client) => {
                this.showHistory(client);
            });

            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                $('#modal-form-client').on('shown.bs.modal', () => {
                    $('#input-client-name').focus();
                });
            },

            show(client) {
                this.$http['get']('/api/clients/' + client.id)
                        .then(response => {
                            this.client = response.data;
                            $('#modal-show-client').modal('show');
                        })
                        .catch(response => {
                            this.client = {};
                            console.log(response);
                        });
            },

            showHistory(client) {
                this.$http['get']('/api/clients/history/' + client.id)
                        .then(response => {
                        this.client = response.data.client;
                        this.history = response.data.history;
                        $('#modal-form-client').modal('hide');
                        $('#modal-client-history').modal('show');
                    })
                    .catch(response => {
                        this.client = {};
                        this.history = [];
                        console.log(response);
                    });
            },

            showCreate() {
                this.editing = false;
                this.creating = true;
                this.form.id = null;
                this.form.name = '';
                this.form.phone = '';
                this.form.email = '';

                $('#modal-form-client').modal('show');
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/clients/' + this.form.id, this.form, '#modal-form-client');
                } else if (this.creating) {
                    this.persist('post', '/api/clients', this.form, '#modal-form-client');
                }
            },

            clearShow() {
                this.client = {};
                $('#modal-show-client').modal('hide');
            },

            showEdit(client) {
                this.clearShow();
                this.editing = true;
                this.creating = false;
                this.form.id = client.id;
                this.form.name = client.name;
                this.form.phone = client.phone;
                this.form.email = client.email;

                $('#modal-client-history').modal('hide');
                $('#modal-form-client').modal('show');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        form.name = '';
                        form.email = '';
                        form.phone = [];

                        this.editing = false;
                        this.creating = false;
                        eventBus.$emit('clientsRefresh');
                        $(modal).modal('hide');
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data));
                        } else {
                            form.errors = [$t('app.http_error')];
                        }
                    });
            },

            delete(client) {
                this.$http.delete('/api/clients/' + client.id)
                        .then(response => {
                    eventBus.$emit('clientsRefresh');
                })
            }
        }
    }
</script>