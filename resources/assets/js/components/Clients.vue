<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $t('clients.title_all') }}</span>
                    <a class="btn btn-sm btn-primary" @click="createClient">{{ $t('app.button_create') }}</a>
                </div>
            </div>

            <div class="panel-body">
                <p style="margin-bottom: 0;" v-if="clients.length === 0">{{ $t('clients.empty') }}</p>
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
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t('app.button_action') }} <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a @click="editClient(client)">{{ $t('app.button_edit') }}</a></li>
                                    <li><a @click="deleteClient(client)">{{ $t('app.button_delete') }}</a></li>
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