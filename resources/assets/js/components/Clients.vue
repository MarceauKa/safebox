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
                    <span>All clients</span>
                    <a class="action-link" @click="createClient">Create New Client</a>
                </div>
            </div>

            <div class="panel-body">
                <p class="m-b-none" v-if="clients.length === 0">You have not created any clients.</p>
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
                            <a class="action-link" @click="editClient(client)">Edit</a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="deleteClient(client)">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                this.getClients()
            })

            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                this.getClients();
            },

            getClients() {
                this.$http
                    .get('/api/clients')
                    .then(response => {
                        this.clients = response.data;
                    })
            }
        }
    }
</script>