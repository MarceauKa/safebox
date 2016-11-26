<template>
    <div>
        <div class="modal fade" id="modal-show-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Client - {{ client.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{ client.name }}<br>
                            <a :href="`mailto:${client.email}`">{{ client.email }}</a><br>
                            <a :href="`tel:${client.phone}`">{{ client.tel }}</a><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="showEdit(client)">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-form-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" v-if="creating">Create client</h4>
                        <h4 class="modal-title" v-if="editing">Edit {{ form.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in form.errors">{{ error }}</li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <input id="input-client-name" type="text" class="form-control" v-model="form.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control" name="email" v-model="form.email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="phone" v-model="form.phone">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="save">Save Changes</button>
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
                this.show(client)
            })

            eventBus.$on('clientEntryCreate', () => {
                this.showCreate()
            })

            eventBus.$on('clientEntryEdit', (client) => {
                this.showEdit(client)
            })

            eventBus.$on('clientEntryDelete', (client) => {
                this.delete(client)
            })
        },

        methods: {
            prepareComponent() {
                $('#modal-form-client').on('shown.bs.modal', () => {
                    $('#input-client-name').focus()
                })
            },

            show(client) {
                this.$http['get']('/api/clients/' + client.id)
                        .then(response => {
                            this.client = response.data;
                            $('#modal-show-client').modal('show');
                        })
                        .catch(response => {
                            console.log(response);
                        })
            },

            showCreate() {
                this.editing = false;
                this.creating = true;
                $('#modal-form-client').modal('show')
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/clients/' + this.form.id, this.form, '#modal-form-client');
                } else if (this.creating) {
                    this.persist('post', '/api/clients', this.form, '#modal-form-client')
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

                $('#modal-form-client').modal('show');
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        form.name = '';
                        form.email = '';
                        form.phone= [];

                        this.editing = false;
                        this.creating = false;
                        eventBus.$emit('clientsRefresh');
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

            delete(client) {
                this.$http.delete('/api/clients/' + client.id)
                        .then(response => {
                    eventBus.$emit('clientsRefresh');
                })
            }
        }
    }
</script>