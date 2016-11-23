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
                        All clients
                    </span>

                    <a class="action-link" @click="showCreateClientForm">
                        Create New Client
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Current Clients -->
                <p class="m-b-none" v-if="clients.length === 0">
                    You have not created any clients.
                </p>

                <table class="table table-borderless m-b-none" v-if="clients.length > 0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client in clients">
                        <td style="vertical-align: middle;">
                            {{ client.name }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ client.email }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ client.phone }}
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="showEditClientForm(client)">
                                Edit
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(client)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Create Client
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
                                    <input id="create-client-name" type="text" class="form-control" v-model="createForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>

                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" v-model="createForm.email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="createForm.phone">
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
        <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog">
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
                                    <input id="edit-client-name" type="text" class="form-control" v-model="editForm.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>

                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" v-model="editForm.email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="editForm.phone">
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

        data() {
            return {
                clients: [],

                createForm: {
                    errors: [],
                    name: '',
                    email: '',
                    phone: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    email: '',
                    phone: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {

                this.getClients();

                $('#modal-create-client').on('shown.bs.modal', () => {
                    $('#create-client-name').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-client-name').focus();
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                this.$http
                    .get('/api/clients')
                    .then(response => {
                        this.clients = response.data;
                    })
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                $('#modal-create-client').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                        'post', '/api/clients',
                        this.createForm, '#modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            showEditClientForm(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.phone = client.phone;
                this.editForm.email = client.email;

                $('#modal-edit-client').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                        'put', '/api/clients/' + this.editForm.id,
                        this.editForm,
                        '#modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.email = '';
                        form.phone= [];

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
                this.$http.delete('/api/clients/' + client.id)
                    .then(response => {
                        this.getClients();
                    });
            }
        }
    }
</script>