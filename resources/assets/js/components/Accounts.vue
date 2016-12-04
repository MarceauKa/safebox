<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>All accounts</span>
                    <a class="btn btn-sm btn-primary" @click="createAccount">Create New Account</a>
                </div>
            </div>
            <div class="panel-body">
                <p style="margin-bottom: 0" v-if="accounts.length === 0">You have not created any accounts.</p>
                <table class="table table-borderless" style="margin-bottom: 0" v-if="accounts.length > 0">
                    <thead>
                    <tr>
                        <th>Site</th>
                        <th>Type</th>
                        <th>Identifiant</th>
                        <th>Password</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="account in accounts">
                        <td style="vertical-align: middle;">{{ account.accountable.name }}</td>
                        <td style="vertical-align: middle;"><span class="label label-default">{{ account.type_name }}</span></td>
                        <td style="vertical-align: middle;">{{ account.credential_login }}</td>
                        <td style="vertical-align: middle;">
                            <a @click="copyToClipboard(account, $event)">Copy</a>
                        </td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a @click="editAccount(account)">Edit</a></li>
                                    <li><a @click="deleteAccount(account)">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginator source="/api/accounts" v-on:fetch="update"></paginator>
            </div>
        </div>
    </div>
</template>

<script>

    import siteMixins from '../mixins/sites'
    import accountMixins from '../mixins/accounts'

    export default {

        mixins: [siteMixins, accountMixins],

        data() {
            return {
                accounts: []
            };
        },

        mounted() {
            eventBus.$on('accountsRefresh', () => {
                eventBus.$emit('paginatorRefresh');
            })
        },

        methods: {
            copyToClipboard(account, event) {

                let $elem = $(event.target).eq(0),
                    $input = $('<input type="text" />').attr('value', account.credential_password);

                $elem.fadeOut(200).fadeIn(200);
                $input.appendTo('body');
                $input.select();
                document.execCommand('copy');
                $input.remove();
            },

            update(data) {
                this.accounts = data
            }
        }
    }
</script>