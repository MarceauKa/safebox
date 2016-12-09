<template>
    <div>
        <!-- Modal Show -->
        <div class="modal fade" id="modal-show-account" tabindex="-1" role="dialog" v-show="account">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Account</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="showEdit(account)">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal create / edit -->
        <div class="modal fade" id="modal-form-account" tabindex="-1" role="dialog" v-show="account">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="creating">{{ $t('accounts.title_create') }}</h4>
                        <h4 class="modal-title" v-if="editing">{{ $t('accounts.title_edit') }}</h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p>{{ $t('app.validation_errors') }}<br>
                            <ul>
                                <li v-for="error in form.errors">{{ error }}</li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form" autocomplete="off">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('accounts.site') }}</label>
                                <div class="col-md-7">
                                    <select name="site_id" v-model="form.site_id" class="form-control">
                                        <option value="">{{ $t('app.option_choose') }}</option>
                                        <option v-for="(site, index) in sites" :value="index" v-text="site"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('accounts.type') }}</label>
                                <div class="col-md-7">
                                    <select name="type" v-model="form.type" class="form-control">
                                        <option value="">{{ $t('app.option_choose') }}</option>
                                        <option v-for="(type, key, index) in types" :value="key">{{ type }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('accounts.login') }}</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="input-account-login" name="credential_login"
                                           v-model="form.credential_login" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ $t('accounts.password') }}</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" id="input-account-password" name="credential_password"
                                           v-model="form.credential_password" autocomplete="off">
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ $t('app.button_close') }}</button>
                            <button type="button" class="btn btn-default" @click="showHistory(form)" v-show="editing">{{ $t('app.button_history') }}</button>
                            <button type="button" class="btn btn-primary" @click="save">{{ $t('app.button_save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal history -->
        <div class="modal fade" id="modal-account-history" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('app.button_history') }}</h4>
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
                        <button type="button" class="btn btn-primary" @click="showEdit(account)">{{ $t('app.button_edit') }}</button>
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
                types: [],
                account: {},
                sites: {},
                history: [],
                form: {
                    errors: [],
                    type: '',
                    site_id: '',
                    credential_login: '',
                    credential_password: ''
                }
            };
        },

        mounted() {
            eventBus.$on('accountEntryShow', (account) => {
                this.show(account);
            });

            eventBus.$on('accountEntryCreate', () => {
                this.showCreate();
            });

            eventBus.$on('accountEntryEdit', (account) => {
                this.showEdit(account);
            });

            eventBus.$on('accountEntryDelete', (account) => {
                this.delete(account);
            });

            eventBus.$on('accountHistoryShow', (account) => {
                this.showHistory(account);
            });

            this.getTypes();
            this.getSites();
        },

        methods: {

            getTypes() {
                this.$http.get('/api/accounts/types')
                        .then(response => {
                            this.types = response.data;
                        })
                        .catch(response => {
                            console.log(response);
                        })
            },

            getSites() {
                this.$http.get('/api/sites/list')
                        .then(response => {
                            this.sites = response.data;
                        });
            },

            show(account) {
                this.$http['get']('/api/accounts/' + account.id)
                        .then(response => {
                            this.account = response.data;
                            $('#modal-show-account').modal('show');
                        })
                        .catch(response => {
                            console.log(response);
                        })
            },

            showCreate() {
                this.editing = false;
                this.creating = true;
                this.form.id = null;
                this.form.site_id = '';
                this.form.type = '';
                this.form.credential_login =  '';
                this.form.credential_password =  '';

                $('#modal-form-account').modal('show');
                $('#input-account-login').val('');
                $('#input-account-password').val('');
            },

            showHistory(account) {
                this.$http['get']('/api/accounts/history/' + account.id)
                        .then(response => {
                    this.account = response.data.account;
                    this.history = response.data.history;

                    $('#modal-form-account').modal('hide');
                    $('#modal-account-history').modal('show');
                })
                .catch(response => {
                    this.sites = {};
                    this.history = [];
                    console.log(response);
                })
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/accounts/' + this.form.id, this.form, '#modal-form-account');
                } else if (this.creating) {
                    this.persist('post', '/api/accounts', this.form, '#modal-form-account');
                }
            },

            clearShow() {
                this.site = {};
                $('#modal-show-account').modal('hide');
            },

            showEdit(account) {
                this.clearShow();

                this.editing = true;
                this.creating = false;
                this.form.id = account.id;
                this.form.type = account.type;
                this.form.site_id = account.accountable.id;
                this.form.credential_login = account.credential_login;
                this.form.credential_password = account.credential_password;

                $('#modal-account-history').modal('hide');
                $('#modal-form-account').modal('show');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        form.type = '';
                        form.site_id = '';
                        form.credential_login = '';
                        form.credential_password = '';

                        this.editing = false;
                        this.creating = false;
                        eventBus.$emit('accountsRefresh');
                        $(modal).modal('hide');
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data));
                        } else {
                            form.errors = [$('app.http_error')];
                        }
                    });
            },

            delete(account) {
                this.$http.delete('/api/accounts/' + account.id).then(response => {
                    eventBus.$emit('accountsRefresh');
                });
            }
        }
    }
</script>