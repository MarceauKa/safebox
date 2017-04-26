<template>
    <div>
        <div class="row">
            <div class="col-xs-9">
                <div class="form-group">
                    <label>{{ $t('accounts.types.mysql.host') }}</label>
                    <input type="text" class="form-control" name="host"
                           v-model="form.host" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>{{ $t('accounts.types.mysql.port') }}</label>
                    <input type="number" class="form-control" name="port"
                           v-model="form.port" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.mysql.login') }}</label>
                    <input type="text" class="form-control" name="login"
                           v-model="form.login" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.mysql.password') }}</label>
                    <input type="password" class="form-control" name="password"
                           v-model="form.password" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{ $t('accounts.types.mysql.database') }}</label>
            <input type="text" class="form-control" name="database"
                   v-model="form.database" autocomplete="off">
        </div>

        <div class="form-group">
            <label>{{ $t('accounts.types.mysql.comment') }}</label>
            <textarea class="form-control" name="comment" v-model="form.comment"></textarea>
        </div>
    </div>
</template>

<script>
    import accountsTypesMixins from '../../mixins/accountsTypes';

    export default {

        mixins: [
            accountsTypesMixins
        ],

        data() {
            return {
                form: {
                    host: 'localhost',
                    port: 3306,
                    login: '',
                    database: '',
                    password: '',
                    comment: '',
                }
            };
        },

        watch: {
            'form.hors': function () {
                this.emitUpdate();
            },
            'form.port': function () {
                this.emitUpdate();
            },
            'form.login': function () {
                this.emitUpdate();
            },
            'form.password': function () {
                this.emitUpdate();
            },
            'form.database': function () {
                this.emitUpdate();
            },
            'form.comment': function () {
                this.emitUpdate();
            }
        }
    }
</script>