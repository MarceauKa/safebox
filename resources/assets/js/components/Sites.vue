<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $t('sites.title_all') }}</span>
                    <a class="btn btn-primary" @click="createSite">{{ $t('app.button_create') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <p style="margin-bottom: 0;" v-if="sites.length == 0">{{ $t('sites.empty') }}</p>
                <div class="table-responsive">
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
                                <div class="btn-group btn-group-sm">
                                    <a @click="showSite(site)" class="btn btn-default" :title="$t('app.button_see')">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a @click="editSite(site)" class="btn btn-default" :title="$t('app.button_edit')">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a @click="deleteSite(site)" class="btn btn-default" :title="$t('app.button_delete')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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