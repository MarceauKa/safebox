<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $t('accounts.title_all') }}</span>
                    <a class="btn btn-sm btn-primary" @click="createAccount">{{ $t('app.button_create') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <p style="margin-bottom: 0" v-if="accounts.length === 0">{{ $t('accounts.empty') }}</p>
                <table class="table table-borderless" style="margin-bottom: 0" v-if="accounts.length > 0">
                    <thead>
                    <tr>
                        <th>{{ $t('accounts.site') }}</th>
                        <th>{{ $t('accounts.type') }}</th>
                        <th>{{ $t('accounts.login') }}</th>
                        <th>{{ $t('accounts.password') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="account in accounts">
                        <td style="vertical-align: middle;">{{ account.accountable.name }}</td>
                        <td style="vertical-align: middle;"><span class="label label-default">{{ account.type_name }}</span></td>
                        <td style="vertical-align: middle;">{{ account.credential_login }}</td>
                        <td style="vertical-align: middle;"><password :password="account.credential_password"></password></td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t('app.button_action') }} <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a @click="editAccount(account)">{{ $t('app.button_edit') }}</a></li>
                                    <li><a @click="deleteAccount(account)">{{ $t('app.button_delete') }}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginator :source="url" v-on:fetch="update"></paginator>
            </div>
        </div>
    </div>
</template>

<script>

    import siteMixins from '../mixins/sites';
    import accountMixins from '../mixins/accounts';

    export default {

        mixins: [siteMixins, accountMixins],

        props: {
            siteId: {
                type: Number,
                default: 0
            }
        },

        data() {
            return {
                accounts: []
            };
        },

        mounted() {
            eventBus.$on('accountsRefresh', () => {
                eventBus.$emit('paginatorRefresh');
            });
        },

        computed: {
            url: function() {
                return this.siteId ? '/api/sites/accounts/' + this.siteId : '/api/accounts';
            }
        },

        methods: {
            update(data) {
                this.accounts = data;
            }
        }
    }
</script>