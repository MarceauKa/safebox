<template>
    <div>
        <div class="modal fade" id="modal-show-site" tabindex="-1" role="dialog" v-show="site">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Site - {{ site.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="showEdit(client)">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-form-site" tabindex="-1" role="dialog" v-show="site">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">
                            Edit Site
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p><br>
                            <ul>
                                <li v-for="error in form.errors">{{ error }}</li>
                            </ul>
                        </div>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <input id="input-site-name" type="text" class="form-control" v-model="form.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">URL</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="url" v-model="form.url">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client</label>
                                <div class="col-md-7">
                                    <select name="client_id" class="form-control" v-model="form.client_id">
                                        <option v-for="client in clients" :value="client.id">{{ client.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="save">Save</button>
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
                site: {},
                clients: [],
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
                this.show(site)
            })

            eventBus.$on('siteEntryCreate', () => {
                this.showCreate()
            })

            eventBus.$on('siteEntryEdit', (site) => {
                this.showEdit(site)
            })

            eventBus.$on('siteEntryDelete', (site) => {
                this.delete(site)
            })
        },

        methods: {

            getClients() {
                this.$http.get('/api/clients')
                        .then(response => {
                            this.clients = response.data.length > 0 ? response.data : [];
                        })
            },

            prepareComponent() {
                $('#create-form-site').on('shown.bs.modal', () => {
                    $('#input-site-name').focus()
                })
            },

            show(site) {
                this.getClients();
                this.$http['get']('/api/sites/' + site.id)
                        .then(response => {
                            this.site = response.data;
                            $('#modal-show-site').modal('show');
                        })
                        .catch(response => {
                            console.log(response);
                        })
            },

            showCreate() {
                this.getClients();
                this.editing = false;
                this.creating = true;
                $('#modal-form-site').modal('show')
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/sites/' + this.form.id, this.form, '#modal-form-site');
                } else if (this.creating) {
                    this.persist('post', '/api/sites', this.form, '#modal-form-site')
                }
            },

            clearShow() {
                this.site = {};
                $('#modal-show-site').modal('hide');
            },

            showEdit(site) {
                this.getClients();
                this.clearShow();
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
                        form.name = '';
                        form.url = '';
                        form.client_id = [];

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
                    })
            },

            delete(site) {
                this.$http.delete('/api/sites/' + site.id).then(response => {
                    eventBus.$emit('sitesRefresh');
                })
            }
        }
    }
</script>