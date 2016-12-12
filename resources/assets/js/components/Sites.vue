<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $t('sites.title_all') }}</span>
                    <a class="btn btn-sm btn-primary" @click="createSite">{{ $t('app.button_create') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <p style="margin-bottom: 0;" v-if="sites.length == 0">{{ $t('sites.empty') }}</p>
                <table class="table table-borderless" style="margin-bottom: 0;" v-if="sites.length > 0">
                    <thead>
                    <tr>
                        <th>{{ $t('sites.name') }}</th>
                        <th>{{ $t('sites.url') }}</th>
                        <th>{{ $t('sites.client') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="site in sites">
                        <td style="vertical-align: middle;">{{ site.name }}</td>
                        <td style="vertical-align: middle;">{{ site.url }}</td>
                        <td style="vertical-align: middle;"><a class="btn-link" @click.prevent="showClient(site.client)">{{ site.client.name }}</a></td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t('app.button_action') }} <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a @click="showSite(site)">{{ $t('app.button_see') }}</a></li>
                                    <li><a @click="editSite(site)">{{ $t('app.button_edit') }}</a></li>
                                    <li><a @click="deleteSite(site)">{{ $t('app.button_delete') }}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginator source="/api/sites" v-on:fetch="update"></paginator>
            </div>
        </div>
    </div>
</template>

<script>

    import clientMixins from '../mixins/clients';
    import siteMixins from '../mixins/sites';

    export default {

        mixins: [clientMixins, siteMixins],

        data() {
            return {
                sites: []
            };
        },

        mounted() {
            eventBus.$on('sitesRefresh', () => {
                eventBus.$emit('paginatorRefresh');
            });
        },

        methods: {
            update(data) {
                this.sites = data;
            }
        }
    }
</script>