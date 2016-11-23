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
                        All sites
                    </span>

                    <a class="action-link" @click="showCreateSiteForm">
                        Create New Site
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <p class="m-b-none" v-if="sites.length === 0">
                    You have not created any sites.
                </p>

                <table class="table table-borderless m-b-none" v-if="sites.length > 0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Client</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="site in sites">
                        <td style="vertical-align: middle;">
                            {{ site.name }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ site.url }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ site.client.name }}
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="showEditSiteForm(site)">
                                Edit
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(site)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Site Modal -->
        <div class="modal fade" id="modal-create-site" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Create Site
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

                        <!-- Create Client Form -->
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-site-name" type="text" class="form-control" v-model="createForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">URL</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url" v-model="createForm.url">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client</label>

                                <div class="col-md-7">
                                    <select name="client_id" class="form-control" v-model="createForm.client_id">
                                        <option v-for="client in clients" :value="client.id">{{ client.name }}</option>
                                    </select>
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

        <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-site" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Client
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

                        <!-- Edit Client Form -->
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="edit-site-name" type="text" class="form-control" v-model="editForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">URL</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url" v-model="editForm.url">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client</label>

                                <div class="col-md-7">
                                    <select name="client_id" class="form-control" v-model="editForm.client_id">
                                        <option v-for="client in clients" :value="client.id">{{ client.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>

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

        data() {
            return {
                clients: [],
                sites: [],

                createForm: {
                    errors: [],
                    name: '',
                    url: '',
                    client_id: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    url: '',
                    client_id: ''
                }
            };
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {
            prepareComponent() {

                this.getClients();
                this.getSites();

                $('#modal-create-site').on('shown.bs.modal', () => {
                    $('#create-site-name').focus();
                });

                $('#modal-edit-site').on('shown.bs.modal', () => {
                    $('#edit-site-name').focus();
                });
            },

            getClients() {
                this.$http
                    .get('/api/clients')
                    .then(response => {
                        this.clients = response.data.length > 0 ? response.data : [];
                    })
            },

            getSites() {
                this.$http
                        .get('/api/sites')
                        .then(response => {
                            this.sites = response.data.length > 0 ? response.data : [];
                        })
            },

            showCreateSiteForm() {
                this.createForm.name = '';
                this.createForm.url = '';
                this.createForm.client_id = '';

                $('#modal-create-site').modal('show');
            },

            store() {
                this.persist('post', '/api/sites', this.createForm, '#modal-create-site');
            },

            showEditSiteForm(site) {
                this.editForm.id = site.id;
                this.editForm.name = site.name;
                this.editForm.url = site.url;
                this.editForm.client_id = site.client_id;

                $('#modal-edit-site').modal('show');
            },

            update() {
                this.persist('put', '/api/sites/' + this.editForm.id, this.editForm, '#modal-edit-site');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        this.getSites();

                        form.name = '';
                        form.url = '';
                        form.client_id = '';

                        $(modal).modal('hide');
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    })
            },

            destroy(site) {
                this.$http.delete('/api/sites/' + site.id)
                    .then(response => {
                        this.getSites();
                    })
            }
        }
    }
</script>