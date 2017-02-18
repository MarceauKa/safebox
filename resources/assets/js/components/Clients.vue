<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $t('clients.title_all') }}</span>
                    <a class="btn btn-primary" @click="createClient">{{ $t('app.button_create') }}</a>
                </div>
            </div>

            <div class="panel-body">
                <p style="margin-bottom: 0;" v-if="clients.length === 0">{{ $t('clients.empty') }}</p>
                <div class="table-responsive">
                    <table class="table table-borderless m-b-none" v-if="clients.length > 0">
                        <thead>
                        <tr>
                            <th>{{ $t('clients.name') }}</th>
                            <th>{{ $t('clients.email') }}</th>
                            <th>{{ $t('clients.phone') }}</th>
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
                                <div class="btn-group btn-group-sm btn-actions">
                                    <a @click="editClient(client)" class="btn btn-default">
                                        <i class="fa fa-pencil"></i>
                                        <span class="tooltip">{{ $t('app.button_edit') }}</span>
                                    </a>
                                    <a @click="deleteClient(client)" class="btn btn-default">
                                        <i class="fa fa-trash"></i>
                                        <span class="tooltip tooltip-danger">{{ $t('app.button_delete') }}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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