<template>
    <div>
        <!-- Modal Show -->
        <div class="modal fade" id="modal-show-site" tabindex="-1" role="dialog" v-show="site">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
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
        <!-- Modal create / edit -->
        <div class="modal fade" id="modal-form-site" tabindex="-1" role="dialog" v-show="site">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="creating">Create site</h4>
                        <h4 class="modal-title" v-if="editing">Edit {{ form.name }}</h4>
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
                                        <option value="">Choose...</option>
                                        <option v-for="client in clients" :value="client.id">{{ client.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" @click="showHistory(form)" v-show="editing">History</button>
                            <button type="button" class="btn btn-primary" @click="save">Save</button>
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
                        <h4 class="modal-title">History - {{ site.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="history.length > 0">
                            <div v-for="dates in history">
                                <h4>{{ dates.date }}</h4>
                                <table class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>From</th>
                                        <th>To</th>
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
                        <div class="alert alert-info" v-if="history.length == 0">There's no history for this site.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="showEdit(site)">Edit</button>
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

            eventBus.$on('siteHistoryShow', (site) => {
                this.showHistory(site)
            })

            this.prepareComponent()
        },

        methods: {

            getClients() {
                this.$http.get('/api/clients/list')
                        .then(response => {
                            this.clients = response.data
                        })
            },

            prepareComponent() {
                $('#modal-form-site').on('shown.bs.modal', () => {
                    $('#input-site-name').focus()
                })
            },

            show(site) {
                this.getClients()

                this.$http['get']('/api/sites/' + site.id)
                        .then(response => {
                            this.site = response.data
                            $('#modal-show-site').modal('show')
                        })
                        .catch(response => {
                            console.log(response)
                        })
            },

            showCreate() {
                this.getClients()

                this.editing = false
                this.creating = true
                this.form.id = null
                this.form.name = ''
                this.form.url = ''
                this.form.client_id = null

                $('#modal-form-site').modal('show')
            },

            showHistory(site) {
                this.$http['get']('/api/sites/history/' + site.id)
                        .then(response => {
                    this.site = response.data.site
                    this.history = response.data.history

                    $('#modal-form-site').modal('hide')
                    $('#modal-site-history').modal('show')
                })
                .catch(response => {
                    this.site = {}
                    this.history = []
                    console.log(response)
                })
            },

            save() {
                if (this.editing) {
                    this.persist('put', '/api/sites/' + this.form.id, this.form, '#modal-form-site');
                } else if (this.creating) {
                    this.persist('post', '/api/sites', this.form, '#modal-form-site')
                }
            },

            clearShow() {
                this.site = {}
                $('#modal-show-site').modal('hide')
            },

            showEdit(site) {
                this.getClients()
                this.clearShow()

                this.editing = true
                this.creating = false
                this.form.id = site.id
                this.form.name = site.name
                this.form.url = site.url
                this.form.client_id = site.client_id

                $('#modal-site-history').modal('hide')
                $('#modal-form-site').modal('show')
            },

            persist(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                    .then(response => {
                        form.name = ''
                        form.url = ''
                        form.client_id = []

                        this.editing = false
                        this.creating = false
                        eventBus.$emit('sitesRefresh')
                        $(modal).modal('hide')
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data))
                        } else {
                            form.errors = ['Something went wrong. Please try again.']
                        }
                    })
            },

            delete(site) {
                this.$http.delete('/api/sites/' + site.id).then(response => {
                    eventBus.$emit('sitesRefresh')
                })
            }
        }
    }
</script>