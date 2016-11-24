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
                    <span>All sites</span>
                    <a class="action-link" @click="createSite">Create New Site</a>
                </div>
            </div>
            <div class="panel-body">
                <p class="m-b-none" v-if="sites.length === 0">You have not created any sites.</p>
                <table class="table table-borderless m-b-none" v-if="sites.length > 0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Client</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="site in sites">
                        <td style="vertical-align: middle;">{{ site.name }}</td>
                        <td style="vertical-align: middle;">{{ site.url }}</td>
                        <td style="vertical-align: middle;"><a class="btn-link" @click.prevent="showClient(site.client)">{{ site.client.name }}</a></td>
                        <td style="vertical-align: middle;">
                            <a class="action-link" @click="editSite(site)">Edit</a>
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="deleteSite(site)">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                this.getSites()
            })

            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                this.getSites();
            },

            getSites() {
                this.$http
                        .get('/api/sites')
                        .then(response => {
                            this.sites = response.data.length > 0 ? response.data : [];
                        })
            }
        }
    }
</script>