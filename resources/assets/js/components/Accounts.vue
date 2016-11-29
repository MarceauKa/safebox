<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        All accounts
                    </span>

                    <a class="btn btn-sm btn-primary" @click="showCreateAccountForm">
                        Create New Account
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Current Accounts -->
                <p class="m-b-none" v-if="accounts.length === 0">
                    You have not created any accounts.
                </p>

                <table class="table table-borderless m-b-none" v-if="accounts.length > 0">
                    <thead>
                    <tr>
                        <th>Site</th>
                        <th>Type</th>
                        <th>Identifiant</th>
                        <th>Password</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="account in accounts">
                        <td style="vertical-align: middle;">
                            {{ account.accountable.name }}
                        </td>
                        <td style="vertical-align: middle;">
                            <span class="label label-default">{{ account.type_name }}</span>
                        </td>
                        <td style="vertical-align: middle;">
                            {{ account.credential_login }}
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="copyToClipboard(account, $event)">Copy</a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="showEditAccountForm(account)">
                                Edit
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(account)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Account Modal -->
        <div class="modal fade" id="modal-create-account" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Create Account
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Account Form -->
                        <form class="form-horizontal" role="form" autocomplete="off">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Site</label>

                                <div class="col-md-7">
                                    <select name="type" v-model="createForm.site_id" class="form-control">
                                        <option value="">Choose...</option>
                                        <option v-for="(site, index) in sites" :value="index">{{ site }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Type</label>

                                <div class="col-md-7">
                                    <select name="type" v-model="createForm.type" class="form-control">
                                        <option value="">Choose...</option>
                                        <option v-for="(type, key, index) in types" :value="key">{{ type }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Identifiant</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="credential_login"
                                           v-model="createForm.credential_login" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mot de passe</label>

                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="credential_password"
                                           v-model="createForm.credential_password" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Account Modal -->
        <div class="modal fade" id="modal-edit-account" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Account
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Account Form -->
                        <form class="form-horizontal" role="form" autocomplete="off">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Type</label>

                                <div class="col-md-7">
                                    <select name="type" v-model="editForm.type" class="form-control">
                                        <option value="">Choose...</option>
                                        <option v-for="type in types" :value="$index">{{ type }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Identifiant</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="credential_login"
                                           v-model="editForm.credential_login" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mot de passe</label>

                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="credential_password"
                                           v-model="editForm.credential_password" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: {
            types: {
                type: Object,
                default: function() {
                    return {}
                }
            }
        },

        data() {
            return {
                sites: [],
                accounts: [],

                createForm: {
                    errors: [],
                    type: '',
                    site_id: 0,
                    credential_login: '',
                    credential_password: ''
                },

                editForm: {
                    errors: [],
                    type: '',
                    credential_login: '',
                    credential_password: ''
                }
            };
        },

        ready() {
            this.prepareComponent();
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {
            prepareComponent() {

                $('input[autocomplete="off"]').val(' ');

                this.getSites();
                this.getAccounts();
            },

            copyToClipboard(account, event) {

                let $elem = $(event.target).eq(0),
                    $input = $('<input type="text" />').attr('value', account.credential_password);

                $elem.fadeOut(200).fadeIn(200);
                $input.appendTo('body');
                $input.select();
                document.execCommand('copy');
                $input.remove();
            },

            getSites() {
                this.$http
                    .get('/api/sites/list')
                    .then(response => {
                        this.sites = response.data;
                    })
            },

            getAccounts() {
                this.$http
                        .get('/api/accounts')
                        .then(response => {
                    this.accounts = response.data;
                })
            },

            showCreateAccountForm() {
                $('#modal-create-account').modal('show');
            },

            store() {
                this.persist('post', '/api/accounts',this.createForm, '#modal-create-account');
            },

            showEditAccountForm(client) {
                this.editForm.id = client.id;
                this.editForm.type = client.type;
                this.editForm.credential_login = client.credential_login;
                this.editForm.credential_password = client.credential_password;

                $('#modal-edit-account').modal('show');
            },

            update() {
                this.persist('put', '/api/accounts/' + this.editForm.id, this.editForm, '#modal-edit-account');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        this.getAccounts();

                        form.type = '';
                        form.credential_login = '';
                        form.credential_password = '';

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


            destroy(client) {
                this.$http.delete('/api/accounts/' + client.id)
                    .then(response => {
                        this.getAccounts();
                    });
            }
        }
    }
</script>