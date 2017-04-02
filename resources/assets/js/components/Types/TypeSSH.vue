<template>
    <div>
        <div class="row">
            <div class="col-xs-10">
                <div class="form-group">
                    <label>{{ $t('accounts.types.ssh.host') }}</label>
                    <input type="text" class="form-control" name="host"
                           v-model="form.host" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-2">
                <div class="form-group">
                    <label>{{ $t('accounts.types.ssh.port') }}</label>
                    <input type="number" class="form-control" name="port"
                           v-model="form.port" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.ssh.login') }}</label>
                    <input type="text" class="form-control" name="login"
                           v-model="form.login" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.ssh.password') }}</label>
                    <input type="password" class="form-control" name="password"
                           v-model="form.password" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{ $t('accounts.types.ssh.comment') }}</label>
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
                    host: '',
                    port: 22,
                    login: '',
                    password: '',
                    comment: '',
                }
            };
        },

        watch: {
            'form.host': function () {
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
            'form.comment': function () {
                this.emitUpdate();
            }
        }
    }
</script>