<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>All clients</span>
                    <a class="btn btn-sm btn-primary" @click="createClient">Create New Client</a>
                </div>
            </div>

            <div class="panel-body">
                <p style="margin-bottom: 0;" v-if="clients.length === 0">You have not created any clients.</p>
                <table class="table table-borderless m-b-none" v-if="clients.length > 0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
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
                        <td>
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a @click="editClient(client)">Edit</a></li>
                                    <li><a @click="deleteClient(client)">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginator source="/api/clients" v-on:fetch="update"></paginator>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        mixins: [require('../mixins/clients')],

        data() {
            return {
                clients: []
            };
        },

        mounted() {
            eventBus.$on('clientsRefresh', () => {
                eventBus.$emit('paginatorRefresh');
            })
        },

        methods: {
            update(data) {
                this.clients = data;
            }
        }
    }
</script>